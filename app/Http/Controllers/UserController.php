<?php

namespace App\Http\Controllers;


use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use PhpParser\Node\Expr\Cast\Array_;
use Throwable;

use App\Models\Account;
use App\Models\Icon;
use App\Models\MovementType;
use App\Models\Objective;
use App\Models\ObjectiveOperation;
use App\Models\Operation;
use App\Models\OperationPlanned;
use App\Models\OperationUnschedule;
use App\Models\User;
use App\Models\UserAccount;
use Illuminate\Mail\Transport\ArrayTransport;
use Illuminate\Support\Carbon;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Models\MovementTypeCategories;

class UserController extends Controller
{

    public Array $delete;
    public int $id;
    public Array $categories;
    public Array $news;
    public Array $accounts;
    public Array $accountMovementsTypes;


    public static function listUsers()
    {
        $users = User::getAllUsers();
    
        return view('admin.users.users')
            ->with('users', $users);
    }

    public static function numberOfUsers(): int {
        return User::numberOfUsers();
    }

    public static function storeUser(): RedirectResponse
    {
        $request = request();

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:100', 'unique:users,last_name'],
            'birth_date' => ['nullable', 'date'],
            'rol_id' => ['required', 'exists:roles,id'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'username' => ['nullable', 'string', 'max:75', 'unique:users,username'],
            'password' => ['required', 'string', 'min:8'],
        ], [
            'email.unique' => 'El correo electrónico ya está registrado.',
            'username.unique' => 'El nombre de usuario ya existe.',
            'last_name.unique' => 'Este apellido ya pertenece a otro usuario.',
            'rol_id.exists' => 'El rol seleccionado no es válido.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
        ]);

        if ($validator->fails()) {
            $mensajes = implode(' ', $validator->errors()->all());

            return redirect()->back()
                ->with('error', $mensajes)
                ->withInput();
        }

        $created = User::storeUser($validator->validated());

        if (!$created) {
            return redirect()->back()
                ->with('error', 'Hubo un error al crear el usuario.')
                ->withInput();
        }

        return redirect()->route('users')->with('success', 'Usuario creado correctamente.');
    }

    public static function deleteUser(): JsonResponse
    {
        $request = request();

        $validator = Validator::make($request->all(), [
            'id' => ['required', 'exists:users,id'],
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'El usuario no existe.']);
        }

        $deleted = User::deleteUser($validator->validated()['id']);

        if (!$deleted) {
            return response()->json(['error' => 'Ha ocurrido un error al eliminar el usuario.']);
        }

        return response()->json(['success' => 'Usuario borrado correctamente.']);
    }

    public static function getUserbyId($id)
    {
        $id = request('id');

        $validator = Validator::make(['id' => $id], [
            'id' => ['required', 'exists:users,id'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('error', 'Usuario no existe.')
                ->withInput();
        }

        $user = User::getUserById($id);

        if (!$user) {
            return redirect()->back()
                ->with('error', 'Usuario no encontrado.')
                ->withInput();
        }

        $personalCategories = User::getPersonalCategoriesByUserId($user->id);

        if (!$personalCategories) {
            return redirect()->back()
                ->with('error', 'Categorias personales no encontradas.')
                ->withInput();
        }

        $allIcons = Icon::getAllIconsEnabled();

        if ($allIcons->isEmpty()) {
            return redirect()->back()
                ->with('error', 'No hay iconos disponibles.')
                ->withInput();
        }

        $accounts = UserAccount::getAccountsByUserId($user->id);
        
        if ($accounts->isEmpty()) {
            return redirect()->back()
                ->with('error', 'No hay cuentas asociadas al usuario.')
                ->withInput();
        }

        $movementTypes = MovementType::getEnabledMovementTypes();

        if ($movementTypes->isEmpty()) {
            return redirect()->back()
                ->with('error', 'No hay tipos de movimiento disponibles.')
                ->withInput();
        }

        return view('admin.users.editUser')
            ->with('user', $user)
            ->with('personalCategories', $personalCategories)
            ->with('allIcons', $allIcons)
            ->with('personalAccounts', $accounts)
            ->with('movementTypes', $movementTypes);
    }

    public static function updateUser(): RedirectResponse
    {
        $request = request();

        $validator = Validator::make($request->all(), [
            'id' => ['required', 'exists:users,id'],
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:100'],
            'birth_date' => ['nullable', 'date'],
            'rol_id' => ['required', 'exists:roles,id'],
            'email' => ['required', 'email', 'max:255'],
            'username' => ['nullable', 'string', 'max:75'],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        if ($validator->fails()) {
            return redirect()->route('users')
                ->with('error', $validator->errors()->first())
                ->withInput();
        }

        $data = $validator->validated();
        $user = User::getUserById($data['id']);

        if (!$user) {
            return redirect()->back()->with('error', 'Usuario no encontrado.');
        }

        $updates = [];

        foreach (['name', 'last_name', 'birth_date', 'rol_id', 'email', 'username'] as $field) {
            if ($user->$field != $data[$field]) {
                $updates[$field] = $data[$field];
            }
        }

        if (!empty($data['password']) && !Hash::check($data['password'], $user->password)) {
            $updates['password'] = bcrypt($data['password']);
        }

        if (!empty($updates)) {
            $user->update($updates);
            return redirect()->route('users')->with('success', 'Usuario actualizado correctamente.');
        }

        return redirect()->route('users')->with('success', 'No se realizaron cambios.');
    }

    public function getUser(): ?Authenticatable
    {
        return User::getUser();
    }

    public function updateUserInfoFromInitialSetup($data) : RedirectResponse
    {
        
        try{
            DB::beginTransaction();
            $user = User::updateUserInfoFromInitialSetup($data);
                
            if(!$user){
                throw new \Exception('Error al actualizar el usuario');
            }
            $account = Account::addAccount($data);
            if(!$account){
                throw new \Exception('Error al crear la cuenta del usuario');
            }
            $userAccount = UserAccount::addUserAccount($user->id, $account->id);
            if(!$userAccount){
                throw new \Exception('Error al crear la cuenta del usuario');
            }
            
            //FixedIncomes
            
            $fixedIncomes = $this->setFixedIncomes($data, $account);
            
            if(!empty($fixedIncomes)){
                
                foreach ($fixedIncomes as $key => $value) {
                    $operation = Operation::addOperation($value);
                    if(!$operation){
                        throw new \Exception('Error al añadir los ingresos');
                    }
                    
                    $plannedOperation = OperationPlanned::addPlannedOperation($operation->id, $value);
                    
                    if(!$plannedOperation){
                        throw new \Exception('Error al añadir los ingresos planeados');
                    }
                }
                
                $fixedExpenses = $this->setfixedExpenses($data, $account);
            
                if(!empty($fixedExpenses)){
                    foreach ($fixedExpenses as $key => $value) {
                        $operation = Operation::addOperation($value);

                        if(!$operation){
                            throw new \Exception('Error al añadir los gastos');
                        }

                        $plannedOperation = OperationPlanned::addPlannedOperation($operation->id, $value);

                        if(!$plannedOperation){
                            throw new \Exception('Error al añadir los gastos planeados');
                        }
                    }
                }
            }


            
            $savedMoneyOperation = null;
            if($data['actually_save'] > 0){
                $savedMoney = $this->setSavedMoneyOperation($data, $account);

                if(!empty($savedMoney)){
                    $savedMoneyOperation = Operation::addOperation($savedMoney);

                    if(!$savedMoneyOperation){
                        throw new \Exception('Error al añadir los ahorros');
                    }
                    $unscheduleOperation = OperationUnschedule::addUnscheduleOperation($savedMoneyOperation->id);
                    
                    if(!$unscheduleOperation){
                        throw new \Exception('Error al añadir los ahorros');
                    }
                }
            }
           
            if(isset($data['objective']) || isset($data['personalize_objective'])){
                if(is_null($savedMoneyOperation)){
                    $savedMoneyAmount = 0;
                } else{
                    $savedMoneyAmount = $savedMoneyOperation->amount;
                }
                
                $objective = $this->setObjective($data, $account, $savedMoneyAmount);
                
                if(!empty($objective)){
                    $savedObjective = Objective::addObjective($objective);
                    
                    if(!$savedObjective){
                        throw new \Exception('Error al añadir los ahorros');
                    }
                    if($savedMoneyAmount > 0){
                        $objectiveOperation =  ObjectiveOperation::addObjectiveOperation($savedObjective->id, $savedMoneyOperation->id);
                        if(!$objectiveOperation){
                            throw new \Exception('Error al añadir los ahorros');
                        }
                    }
                }
            }
            

            $allOperations = Operation::getAllOperationsByAccountId($account->id);
            if(!is_null($allOperations)){
                $total = 0;
                foreach ($allOperations as $value) {
                    $amount = (float) $value->amount;

                    if($value->movement_type_id === 1 || $value->movement_type_id === 3){
                        $total += $amount;
                    }elseif($value->movement_type_id === 2){
                        $total-= $amount;
                    }
                }
                if(!Account::updateBalance($account->id, $total)){
                    throw new \Exception('Error al editar el balance de la cuenta actual');
                }
            }
            if(!User::updateNewUser($user)){
                throw new \Exception('Error al cambiar el estado de nuevo usuario');
            }

            DB::commit();
            
            return redirect()->action([DashboardController::class, 'index']);
        } catch (Throwable $e){
            DB::rollback();
            return back()->withInput();
        }

    }


    private function setFixedIncomes(Array $data, Account $account): Array{
        $fixedIncomes = [];

        if (isset($data['salary']) && !is_null($data['salary'])) {
            $fixedIncomes['salary'] = [
                'amount' => $data['salary'],
                'subject' => 'Salario',
                'description' => 'Ingreso mensual por trabajo',
                'action_date' => Carbon::now()->toDateTimeString(),
                'movement_type_id' => 1,
                'account_id' => $account->id,
                'start_date' => Carbon::now()->startOfMonth()->toDateTimeString(),
                'period' => 'm',
                'category_id' => 1, 
            ];
        }

        if (isset($data['familyHelp']) && !is_null($data['familyHelp'])) {
            $fixedIncomes['familyHelp'] = [
                'amount' => $data['familyHelp'],
                'subject' => 'Ayuda familiar',
                'description' => 'Ayuda de la familia mensualmente',
                'action_date' => Carbon::now()->toDateTimeString(),
                'movement_type_id' => 1,
                'account_id' => $account->id,
                'start_date' => Carbon::now()->startOfMonth()->toDateTimeString(),
                'period' => 'm',
                'category_id' => 2, 
            ];
        }
        
        if (isset($data['stateHelp']) && !is_null($data['stateHelp'])) {
            $fixedIncomes['stateHelp'] = [
                'amount' => $data['stateHelp'],
                'subject' => 'Ayudas del estado',
                'description' => 'Ayuda del estado mensual',
                'action_date' => Carbon::now()->toDateTimeString(),
                'movement_type_id' => 1,
                'account_id' => $account->id,
                'start_date' => Carbon::now()->startOfMonth()->toDateTimeString(),
                'period' => 'm',
                'category_id' => 3, 
            ];
        }

        return $fixedIncomes;
    }
    
    private function setSavedMoneyOperation(Array $data, Account $account): Array{
        $savedMoney = [];

        if (isset($data['actually_save']) && !is_null($data['actually_save'])) {
            $savedMoney['amount'] = $data['actually_save'];
            $savedMoney['subject'] = 'Ahorro';
            $savedMoney['description'] = 'Ahorro antes de usar Rivo';
            $savedMoney['action_date'] = Carbon::now()->toDateTimeString();
            $savedMoney['movement_type_id'] = 3;
            $savedMoney['account_id'] = $account->id;
            $savedMoney['category_id'] = 12; 
        }

        return $savedMoney;
    }
    
    private function setFixedExpenses(Array $data, Account $account): Array{

        $fixedExpensesKeys = [
            'homeExpenses' => [
                'amount' => $data['homeExpenses'],
                'subject' => 'Gastos del hogar',
                'description' => 'Gastos del hogar mensuales',
                'action_date' => Carbon::now()->toDateTimeString(),
                'movement_type_id' => 2,
                'account_id' => $account->id,
                'start_date' => Carbon::now()->startOfMonth()->toDateTimeString(),
                'period' => 'm',
                'category_id' => 4,
            ],
            'servicesHomeExpenses' => [
                'amount' => $data['servicesHomeExpenses'],
                'subject' => 'Servicios del hogar',
                'description' => 'Servicios del hogar mensuales',
                'action_date' => Carbon::now()->toDateTimeString(),
                'movement_type_id' => 2,
                'account_id' => $account->id,
                'start_date' => Carbon::now()->startOfMonth()->toDateTimeString(),
                'period' => 'm',
                'category_id' => 5,
            ],
            'feedingExpenses' => [
                'amount' => $data['feedingExpenses'],
                'subject' => 'Alimentación',
                'description' => 'Gastos de alimentación mensuales',
                'action_date' => Carbon::now()->toDateTimeString(),
                'movement_type_id' => 2,
                'account_id' => $account->id,
                'start_date' => Carbon::now()->startOfMonth()->toDateTimeString(),
                'period' => 'm',
                'category_id' => 6,
            ],
            'transportationExpenses' => [
                'amount' => $data['transportationExpenses'],
                'subject' => 'Transporte',
                'description' => 'Gastos de transporte mensuales',
                'action_date' => Carbon::now()->toDateTimeString(),
                'movement_type_id' => 2,
                'account_id' => $account->id,
                'start_date' => Carbon::now()->startOfMonth()->toDateTimeString(),
                'period' => 'm',
                'category_id' => 7,
            ],
            'healthExpenses' => [
                'amount' => $data['healthExpenses'],
                'subject' => 'Salud',
                'description' => 'Gastos de salud mensuales',
                'action_date' => Carbon::now()->toDateTimeString(),
                'movement_type_id' => 2,
                'account_id' => $account->id,
                'start_date' => Carbon::now()->startOfMonth()->toDateTimeString(),
                'period' => 'm',
                'category_id' => 8,
            ],
            'telephoneExpenses' => [
                'amount' => $data['telephoneExpenses'],
                'subject' => 'Teléfono',
                'description' => 'Gastos de teléfono mensuales',
                'action_date' => Carbon::now()->toDateTimeString(),
                'movement_type_id' => 2,
                'account_id' => $account->id,
                'start_date' => Carbon::now()->startOfMonth()->toDateTimeString(),
                'period' => 'm',
                'category_id' => 9,
            ],
            'educationExpenses' => [
                'amount' => $data['educationExpenses'],
                'subject' => 'Educación',
                'description' => 'Gastos de educación mensuales',
                'action_date' => Carbon::now()->toDateTimeString(),
                'movement_type_id' => 2,
                'account_id' => $account->id,
                'start_date' => Carbon::now()->startOfMonth()->toDateTimeString(),
                'period' => 'm',
                'category_id' => 10,
            ],
            'otherExpenses' => [
                'amount' => $data['otherExpenses'],
                'subject' => 'Otros gastos',
                'description' => 'Otros gastos mensuales',
                'action_date' => Carbon::now()->toDateTimeString(),
                'movement_type_id' => 2,
                'account_id' => $account->id,
                'start_date' => Carbon::now()->startOfMonth()->toDateTimeString(),
                'period' => 'm',
                'category_id' => 11,
            ],

        ];
        $fixedExpenses = [];

        foreach ($fixedExpensesKeys as $key => $expenseData) {
            if (isset($data[$key]) && !is_null($data[$key])) {
                $expenseData['amount'] = $data[$key];
                $fixedExpenses[$key] = $expenseData;
            }
        }

        return $fixedExpenses;
    }
    private function setObjective(Array $data, Account $account, Float $savedMoneyAmount): Array{

        $objective = [];

        if (isset($data['personalize_objective']) && !is_null($data['personalize_objective'])){
            $objective = [
                'name' => $data['personalize_objective']
            ];
        }else{
            if (isset($data['objective']) && !is_null($data['objective'])) {
                if($data['objective'] == 1){
                    $objective = [
                        'name' => 'Fondo de emergencia'
                    ];
                }else{
                    if($data['objective'] == 2){
                        $objective = [
                            'name' => 'Salir de deudas'
                        ];
                    }else {
                        if($data['objective'] == 3){
                            $objective = [
                                'name' => 'Ahorros a futuro'
                            ];
                        }
                    }
                }
            }
        }

        $objective['target_amount'] = 2000;
        $objective['account_id'] = $account->id;
        $objective['deadline'] = null;
        $objective['current_amount'] = $savedMoneyAmount;

        if(!isset($objective['name'])){
            return [];
        }
        return $objective;
    }

    public static function updatePersonalCategories($data): RedirectResponse
    {
        $data = $data['data'] ?? [];

        $object = new UserController();
        
        $object->delete = json_decode($data['deleted'] ?? '[]', true);
        $object->id = $data['user_id'] ?? null;
        $object->categories = $data['categories'] ?? [];
        $object->news = $data['news'] ?? [];
        $object->accountMovementsTypes = $data['movement_types'] ?? [];

        if (!User::getUserById($object->id)) {
            return Redirect::back()->with('error', 'El usuario no existe.');
        }
        
        if (!empty($object->delete)) {
            foreach ($object->delete as $categoryId) {
                $category = User::deletePersonalCategory($object->id, $categoryId);
                if (!$category) {
                    return redirect()->route('users')->with('error', 'Error al eliminar la categoría personal.');
                }
            }
        }
        
        if (!empty($object->categories)) {
            foreach ($object->categories as $category) {
                $categoryId = $category['id'] ?? null;
                $categoryName = $category['name'] ?? null;
                $categoryIcon = $category['icon'] ?? null;
                $movementTypes = $object->accountMovementsTypes[$categoryId] ?? [];

                if ($categoryId && $categoryName && $categoryIcon) {

                    $updated = User::updatePersonalCategory($object->id, $categoryId, $categoryName, $categoryIcon);

                    if (!$updated) {
                        return redirect()->route('users')->with('error', 'Error al actualizar la categoría personal.');
                    }

                    MovementTypeCategories::syncTypesOfCategory($categoryId, $movementTypes);
                }
            }
        }

        if (!empty($object->news)) {
            foreach ($object->news as $newCategory) {
                $newCategoryName = $newCategory['name'] ?? null;
                $newCategoryIcon = $newCategory['icon'] ?? null;
                $movementTypes = $newCategory['movement_types'] ?? [];

                if ($newCategoryName && $newCategoryIcon) {
                    $addedCategoryId = User::addPersonalCategory($object->id, $newCategoryName, $newCategoryIcon);
                    if (!$addedCategoryId) {
                        return redirect()->route('users')->with('error', 'Error al añadir la categoría personal.');
                    }

                    MovementTypeCategories::syncTypesOfCategory($addedCategoryId, $movementTypes);
                }
            }
        }

        return redirect()->route('users')->with('success', 'Categorías personales actualizadas correctamente.');
    }


    public static function getFullUserbyId($data)
    {
        
        $objet = new UserController();

        $objet->id = $data['data']['id'] ?? null;

        $user = User::getUserById($objet->id);

        if (!$user) {
            return redirect()->back()
                ->with('error', 'Usuario no encontrado.');
        }

        $personalCategories = User::getPersonalCategoriesByUserId($user->id);

        if (!$personalCategories) {
            return redirect()->back()
                ->with('error', 'Categorias personales no encontradas.');
        }

        $accounts = UserAccount::getAccountsByUserId($user->id);
        
        if ($accounts->isEmpty()) {
            return redirect()->back()
                ->with('error', 'No hay cuentas asociadas al usuario.')
                ->withInput();
        }

        $movementTypes = MovementType::getEnabledMovementTypes();

        if ($movementTypes->isEmpty()) {
            return redirect()->back()
                ->with('error', 'No hay tipos de movimiento disponibles.')
                ->withInput();
        }

        // dd($user, $personalCategories, $accounts, $movementTypes);
        return view('admin.users.previewUser')
            ->with('user', $user)
            ->with('personalCategories', $personalCategories)
            ->with('personalAccounts', $accounts)
            ->with('movementTypes', $movementTypes);

    }

    public static function updatePersonalAccounts($data): RedirectResponse
    {
        $data = $data['data'] ?? [];

        $object = new UserController();
        
        $object->delete = json_decode($data['deleted'] ?? '[]', true);
        $object->id = $data['user_id'] ?? null;
        $object->accounts = $data['accounts'] ?? [];
        $object->news = $data['news'] ?? [];

        if (!User::getUserById($object->id)) {
            return Redirect::back()->with('error', 'El usuario no existe.');
        }

        if (!empty($object->delete)) {
            foreach ($object->delete as $accountId) {
                $account = UserAccount::deletePersonalAccount($object->id, $accountId);
                if (!$account) {
                    return redirect()->route('users')->with('error', 'Error al eliminar la cuenta personal.');
                }
            }
        }
        
        if (!empty($object->accounts)) {
            foreach ($object->accounts as $account) {

                $accountId = $account['id'] ?? null;
                $accountName = $account['name'] ?? null;
                $accountBalance = $account['balance'] ?? null;
                $accountCurrency = $account['currency'] ?? null;
                $accountEnabled = $account['enabled'] ?? null;


                if ($accountId && $accountName && $accountBalance && $accountCurrency) {
                    $updatedAccount = UserAccount::updatePersonalAccount($accountId, $accountName, $accountBalance, $accountCurrency, $accountEnabled);
                    if (!$updatedAccount) {
                        return redirect()->route('users')->with('error', 'Error al actualizar la cuenta personal.');
                    }
                }

            }
        }

        if (!empty($object->news)) {
            foreach ($object->news as $newAccount) {

                $newAccountName = $newAccount['name'] ?? null;
                $newAccountBalance = $newAccount['balance'] ?? null;
                $newAccountCurrency = $newAccount['currency'] ?? null;
                $newAccountEnabled = $newAccount['enabled'] ?? null;

                if ($newAccountName && $newAccountBalance && $newAccountCurrency) {
                    $addedAccount = UserAccount::addPersonalAccount($object->id, $newAccountName, $newAccountBalance, $newAccountCurrency, $newAccountEnabled);
                    if (!$addedAccount) {
                        return redirect()->route('users')->with('error', 'Error al añadir la cuenta personal.');
                    }
                }

            }
        }
        
        return redirect()->route('users')->with('success', 'Cuentas personales actualizadas correctamente.');
    }
}
