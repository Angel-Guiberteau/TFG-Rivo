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
use App\Models\Objective;
use App\Models\ObjectiveOperation;
use App\Models\Operation;
use App\Models\OperationPlanned;
use App\Models\OperationUnschedule;
use App\Models\User;
use App\Models\UserAccount;
use Illuminate\Support\Carbon;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class UserController extends Controller
{

    public static function listUsers()
    {
        $users = User::getAllUsers();
    
        return view('admin.users.users')
            ->with('users', $users);
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

        // dd($personalCategories);

        return view('admin.users.editUser')
            ->with('user', $user)
            ->with('personalCategories', $personalCategories)
            ->with('allIcons', $allIcons);
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
                'action_date' => Carbon::now()->toDateString(),
                'movement_type_id' => 1,
                'account_id' => $account->id,
                'start_date' => Carbon::now()->startOfMonth()->toDateString(),
                'period' => 'm',
            ];
        }

        if (isset($data['familyHelp']) && !is_null($data['familyHelp'])) {
            $fixedIncomes['familyHelp'] = [
                'amount' => $data['familyHelp'],
                'subject' => 'Ayuda familiar',
                'description' => 'Ayuda de la familia mensualmente',
                'action_date' => Carbon::now()->toDateString(),
                'movement_type_id' => 1,
                'account_id' => $account->id,
                'start_date' => Carbon::now()->startOfMonth()->toDateString(),
                'period' => 'm',
            ];
        }
        
        if (isset($data['stateHelp']) && !is_null($data['stateHelp'])) {
            $fixedIncomes['stateHelp'] = [
                'amount' => $data['stateHelp'],
                'subject' => 'Ayudas del estado',
                'description' => 'Ayuda del estado mensual',
                'action_date' => Carbon::now()->toDateString(),
                'movement_type_id' => 1,
                'account_id' => $account->id,
                'start_date' => Carbon::now()->startOfMonth()->toDateString(),
                'period' => 'm',
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
            $savedMoney['action_date'] = Carbon::now()->toDateString();
            $savedMoney['movement_type_id'] = 3;
            $savedMoney['account_id'] = $account->id;
        }

        return $savedMoney;
    }
    
    private function setFixedExpenses(Array $data, Account $account): Array{
        
        $fixedExpensesKeys = [
            'homeExpenses' => 'Casa',
            'servicesHomeExpenses' => 'Luz, agua, gas...',
            'feedingExpenses' => 'Alimentación',
            'transportationExpenses' => 'Transporte',
            'healthExpenses' => 'Salud',
            'telephoneExpenses' => 'Telefonía',
            'educationExpenses' => 'Educación',
            'otherExpenses' => 'Otros gastos fijos'

        ];
        $fixedExpenses = [];

        foreach ($fixedExpensesKeys as $key => $value) {
            if (isset($data[$key]) && !is_null($data[$key])){
                $fixedExpenses[$key] = [
                    'amount' => $data[$key],
                    'subject' => $value,
                    'description' => 'Ingreso mensual por trabajo',
                    'action_date' => Carbon::now()->toDateString(),
                    'movement_type_id' => 2,
                    'account_id' => $account->id,
                    'start_date' => Carbon::now()->startOfMonth()->toDateString(),
                    'period' => 'm',
                ];
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


}
