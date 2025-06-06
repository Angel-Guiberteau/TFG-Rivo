<?php

namespace App\Validations;

class UserValidator extends Validator {

    protected static function rulesAdd(): array {
        return [
            'name' => 'required|string|max:75',
            'last_name' => 'required|string|max:75',
            'birth_date' => 'required|date',
            'rol_id' => 'required|integer',
            'email' => 'required|email|max:255',
            'username' => 'required|string|max:75',
            'password' => 'required|string|min:8|max:255',
        ];
    }

    protected static function messagesAdd(): array {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no puede tener más de 75 caracteres.',

            'last_name.required' => 'Los apellidos son obligatorios.',
            'last_name.string' => 'Los apellidos deben ser una cadena de texto.',
            'last_name.max' => 'Los apellidos no pueden tener más de 75 caracteres.',

            'birth_date.required' => 'La fecha de nacimiento es obligatoria.',
            'birth_date.date' => 'La fecha de nacimiento no es válida.',

            'rol_id.required' => 'El rol es obligatorio.',
            'rol_id.integer' => 'El identificador del rol debe ser un número entero.',

            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico no es válido.',
            'email.max' => 'El correo electrónico no puede tener más de 255 caracteres.',

            'username.required' => 'El nombre de usuario es obligatorio.',
            'username.string' => 'El nombre de usuario debe ser una cadena de texto.',
            'username.max' => 'El nombre de usuario no puede tener más de 75 caracteres.',

            'password.required' => 'La contraseña es obligatoria.',
            'password.string' => 'La contraseña debe ser una cadena de texto.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.max' => 'La contraseña no puede tener más de 255 caracteres.',
        ];
    }

    protected static function rulesEdit(): array {
        return [
            'id' => 'required|integer|exists:users,id',
            'name' => 'required|string|max:75',
            'last_name' => 'required|string|max:75',
            'birth_date' => 'required|date',
            'rol_id' => 'sometimes|integer',
            'email' => 'required|email|max:255',
            'username' => 'required|string|max:75',
            'password' => 'nullable|string|min:8|max:255',
        ];
    }

    protected static function messagesEdit(): array {
        return [
            'id.required' => 'Ha sucedido un error inesperado.',
            'id.integer' => 'Ha sucedido un error inesperado.',
            'id.exists' => 'El usuario no existe o ha sido eliminado.',

            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no puede tener más de 75 caracteres.',

            'last_name.required' => 'Los apellidos son obligatorios.',
            'last_name.string' => 'Los apellidos deben ser una cadena de texto.',
            'last_name.max' => 'Los apellidos no pueden tener más de 75 caracteres.',

            'birth_date.required' => 'La fecha de nacimiento es obligatoria.',
            'birth_date.date' => 'La fecha de nacimiento no es válida.',

            'rol_id.integer' => 'El identificador del rol debe ser un número entero.',

            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico no es válido.',
            'email.max' => 'El correo electrónico no puede tener más de 255 caracteres.',

            'username.required' => 'El nombre de usuario es obligatorio.',
            'username.string' => 'El nombre de usuario debe ser una cadena de texto.',
            'username.max' => 'El nombre de usuario no puede tener más de 75 caracteres.',

            'password.string' => 'La contraseña debe ser una cadena de texto.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.max' => 'La contraseña no puede tener más de 255 caracteres.',
        ];
    }

    protected static function rulesDelete(): array {
        return [
            'id' => 'required|integer|exists:users,id'
        ];
    }

    protected static function messagesDelete(): array {
        return [
            'id.required' => 'Ha sucedido un error inesperado.',
            'id.integer' => 'Ha sucedido un error inesperado.',
            'id.exists' => 'El usuario no existe o ha sido eliminado.'
        ];
    }

    protected static function rulesPreView(): array {
        return [
            'text' => 'required|string|max:255'
        ];
    }

    protected static function messagesPreView(): array {
        return [
            'text.required' => 'No se ha recibido el texto.',
            'text.string' => 'El tipo de dato no es correcto.',
            'text.max' => 'El tamaño del texto no concuerda con el permitido.'
        ];
    }
    
    protected static function rulesInitialSetup(): array {
        return [
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:100',
            'username' => 'required|string|max:75',
            'birth_date' => 'required|date',

            'salary' => 'sometimes|nullable|integer',
            'familyHelp' => 'sometimes|nullable|integer',
            'stateHelp' => 'sometimes|nullable|integer',
            'homeExpenses' => 'sometimes|nullable|integer',
            'servicesHomeExpenses' => 'sometimes|nullable|integer',
            'feedingExpenses' => 'sometimes|nullable|integer',
            'transportationExpenses' => 'sometimes|nullable|integer',
            'healthExpenses' => 'sometimes|nullable|integer',
            'telephoneExpenses' => 'sometimes|nullable|integer',
            'educationExpenses' => 'sometimes|nullable|integer',
            'otherExpenses' => 'sometimes|nullable|integer',

            'percentage' => 'sometimes|nullable|numeric',
            'personalizePercentage' => 'sometimes|nullable|integer',
            'objective' => 'sometimes|nullable|numeric',
            'personalize_objective' => 'sometimes|nullable|string|max:255',

            'variable_freeTime' => 'sometimes|nullable|integer',
            'variable_unexpected' => 'sometimes|nullable|integer',
            'variable_personalCare' => 'sometimes|nullable|integer',
            'variable_purchases' => 'sometimes|nullable|integer',
            'variable_travel' => 'sometimes|nullable|integer',
            'variable_pet' => 'sometimes|nullable|integer',
            'variable_debt' => 'sometimes|nullable|integer',

            'actually_save' => 'sometimes|nullable|integer',
            'account_name' => 'sometimes|nullable|string|max:75',
        ];
    }


    protected static function messagesInitialSetup(): array {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',

            'last_name.required' => 'Los apellidos son obligatorios.',
            'last_name.string' => 'Los apellidos deben ser una cadena de texto.',
            'last_name.max' => 'Los apellidos no pueden tener más de 100 caracteres.',

            'username.required' => 'El nombre de usuario es obligatorio.',
            'username.string' => 'El nombre de usuario debe ser una cadena de texto.',
            'username.max' => 'El nombre de usuario no puede tener más de 75 caracteres.',

            'birth_date.required' => 'La fecha de nacimiento es obligatoria.',
            'birth_date.date' => 'La fecha de nacimiento no es válida.',

            'salary.integer' => 'El sueldo debe ser un número entero.',
            'familyHelp.integer' => 'Las ayudas familiares deben ser un número entero.',
            'stateHelp.integer' => 'Las ayudas del estado deben ser un número entero.',
            'homeExpenses.integer' => 'Los gastos del hogar deben ser un número entero.',
            'servicesHomeExpenses.integer' => 'Los servicios del hogar deben ser un número entero.',
            'feedingExpenses.integer' => 'Los gastos en alimentación deben ser un número entero.',
            'transportationExpenses.integer' => 'Los gastos en transporte deben ser un número entero.',
            'healthExpenses.integer' => 'Los gastos en salud deben ser un número entero.',
            'telephoneExpenses.integer' => 'Los gastos en teléfono deben ser un número entero.',
            'educationExpenses.integer' => 'Los gastos en educación deben ser un número entero.',
            'otherExpenses.integer' => 'Otros gastos deben ser un número entero.',

            'percentage.numeric' => 'El porcentaje debe ser un número.',
            'personalizePercentage.integer' => 'El porcentaje personalizado debe ser un número entero.',
            'objective.string' => 'El objetivo debe ser una cadena de texto.',
            'objective.max' => 'El objetivo no puede tener más de 255 caracteres.',

            'variable_freeTime.integer' => 'El gasto en ocio debe ser un número entero.',
            'variable_unexpected.integer' => 'El gasto en imprevistos debe ser un número entero.',
            'variable_personalCare.integer' => 'El gasto en cuidado personal debe ser un número entero.',
            'variable_purchases.integer' => 'El gasto en compras debe ser un número entero.',
            'variable_travel.integer' => 'El gasto en viajes debe ser un número entero.',
            'variable_pet.integer' => 'El gasto en mascotas debe ser un número entero.',
            'variable_debt.integer' => 'El gasto en deudas debe ser un número entero.',

            'actually_save.integer' => 'El ahorro actual debe ser un número entero.',
            'account_name.string' => 'El nombre de la cuenta debe ser una cadena de texto.',
            'account_name.max' => 'El nombre de la cuenta no puede tener más de 75 caracteres.',
        ];
    }

    protected static function rulesUpdatePersonalCategories(): array {
        return [
            'deleted' => 'required|string',
            'user_id' => 'required|integer',
            'movement_types' => 'sometimes|array',

            'categories' => 'sometimes|array|min:1',
            'categories.*.id' => 'sometimes|integer',
            'categories.*.name' => 'sometimes|string|max:30',
            'categories.*.icon' => 'sometimes|string|max:75',

            'news' => 'sometimes|array',
            'news.*.name' => 'sometimes|string|max:75',
            'news.*.icon' => 'sometimes|string|max:75',
            'news.*.movement_types' => 'sometimes|array',
        ];
    }

    protected static function messagesUpdatePersonalCategories(): array {
        return [
            'deleted.required' => 'La lista de categorías eliminadas es obligatoria.',
            'deleted.string' => 'El formato de las categorías eliminadas no es válido.',

            'movement_types.array' => 'Los tipos de movimiento deben estar en formato de lista.',

            'user_id.required' => 'El usuario es obligatorio.',
            'user_id.integer' => 'El identificador del usuario debe ser un número entero.',

            'categories.required' => 'Debes enviar al menos una categoría existente.',
            'categories.array' => 'Las categorías deben estar en formato de lista.',
            'categories.min' => 'Debes tener al menos una categoría.',

            'categories.*.id.required' => 'Cada categoría existente debe tener un ID.',
            'categories.*.id.integer' => 'El ID de cada categoría debe ser un número.',
            'categories.*.name.required' => 'El nombre de la categoría existente es obligatorio.',
            'categories.*.name.string' => 'El nombre de la categoría existente debe ser texto.',
            'categories.*.name.max' => 'El nombre de la categoría existente no puede exceder los 30 caracteres.',
            'categories.*.icon.required' => 'El icono de la categoría existente es obligatorio.',
            'categories.*.icon.string' => 'El icono de la categoría existente debe ser texto.',
            'categories.*.icon.max' => 'El icono de la categoría existente no puede exceder los 75 caracteres.',

            'news.array' => 'Las nuevas categorías deben estar en formato de lista.',

            'news.*.name.required_with' => 'El nombre de la nueva categoría es obligatorio.',
            'news.*.name.string' => 'El nombre de la nueva categoría debe ser texto.',
            'news.*.name.max' => 'El nombre de la nueva categoría no puede exceder los 75 caracteres.',

            'news.*.movement_types.array' => 'Los tipos de movimiento de la nueva categoría deben estar en formato de lista.',
            'news.*.icon.required_with' => 'El icono de la nueva categoría es obligatorio.',
            'news.*.icon.string' => 'El icono de la nueva categoría debe ser texto.',
            'news.*.icon.max' => 'El icono de la nueva categoría no puede exceder los 75 caracteres.',
        ];
    }

    protected static function rulesUpdatePersonalAccounts(): array {
        return [
            'deleted' => 'required|string',
            'user_id' => 'required|integer',

            'accounts' => 'sometimes|array|min:1',
            'accounts.*.id' => 'sometimes|integer',
            'accounts.*.name' => 'sometimes|string|max:75',
            'accounts.*.balance' => 'sometimes|numeric',
            'accounts.*.currency' => 'sometimes|string|size:3',
            'accounts.*.enabled' => 'sometimes|boolean',

            'news' => 'sometimes|array|min:1',
            'news.*.name' => 'sometimes|string|max:75',
            'news.*.balance' => 'sometimes|numeric',
            'news.*.currency' => 'sometimes|string|size:3',
            'news.*.enabled' => 'sometimes|boolean',
        ];
    }

    protected static function messagesUpdatePersonalAccounts(): array {
        return [
            'deleted.required' => 'La lista de cuentas eliminadas es obligatoria.',
            'deleted.string' => 'El formato de las cuentas eliminadas no es válido.',

            'user_id.required' => 'El usuario es obligatorio.',
            'user_id.integer' => 'El identificador del usuario debe ser un número entero.',

            'accounts.required' => 'Debes enviar al menos una cuenta existente.',
            'accounts.array' => 'Las cuentas deben estar en formato de lista.',
            'accounts.min' => 'Debes tener al menos una cuenta.',

            'accounts.*.id.required' => 'Cada cuenta existente debe tener un ID.',
            'accounts.*.id.integer' => 'El ID de cada cuenta debe ser un número.',
            'accounts.*.name.required' => 'El nombre de la cuenta existente es obligatorio.',
            'accounts.*.name.string' => 'El nombre de la cuenta existente debe ser texto.',
            'accounts.*.name.max' => 'El nombre de la cuenta existente no puede exceder los 75 caracteres.',
            'accounts.*.balance.required' => 'El saldo de la cuenta existente es obligatorio.',
            'accounts.*.balance.decimal' => 'El saldo de la cuenta existente debe ser un número decimal.',
            'accounts.*.currency.required' => 'La moneda de la cuenta existente es obligatoria.',
            'accounts.*.currency.string' => 'La moneda de la cuenta existente debe ser texto.',
            'accounts.*.currency.size' => 'La moneda de la cuenta existente debe tener 3 caracteres.',
            'accounts.*.enabled.boolean' => 'El campo de habilitación de la cuenta existente debe ser verdadero o falso.',

            'news.required' => 'Debes enviar al menos una nueva cuenta.',
            'news.array' => 'Las nuevas cuentas deben estar en formato de lista.',
            'news.min' => 'Debes tener al menos una nueva cuenta.',

            'news.*.name.required' => 'El nombre de la nueva cuenta es obligatorio.',
            'news.*.name.string' => 'El nombre de la nueva cuenta debe ser texto.',
            'news.*.name.max' => 'El nombre de la nueva cuenta no puede exceder los 75 caracteres.',
            'news.*.balance.required' => 'El saldo de la nueva cuenta es obligatorio.',
            'news.*.balance.decimal' => 'El saldo de la nueva cuenta debe ser un número decimal.',
            'news.*.currency.required' => 'La moneda de la nueva cuenta es obligatoria.',
            'news.*.currency.string' => 'La moneda de la nueva cuenta debe ser texto.',
            'news.*.currency.size' => 'La moneda de la nueva cuenta debe tener 3 caracteres.',
            'news.*.enabled.boolean' => 'El campo de habilitación de la nueva cuenta debe ser verdadero o falso.',
        ];
    }
    
    protected static function rulesAddOperationUser(): array {
        return [

            'operation_id' => 'nullable|integer',
            'category_id' => 'required|integer',
            'movement_type' => 'required|string|in:income,expense,save',
            'objectiveId' => 'integer|nullable',

            'subject' => 'required|string|max:75',
            'description' => 'required|string|max:255',

            'action_date' => 'required|date',

            'schedule' => 'sometimes|in:on',

            'start_date'=> 'required_if:schedule,on|nullable|date',
            'expiration_date'=> 'required_if:schedule,on|nullable|date',
            'period' => 'required_if:schedule,on|string|max:1',

            'amount' => 'required|numeric',
        ];
    }

    protected static function messagesAddOperationUser(): array {
        return [
            'movement_type.required'  => 'El tipo de operación es obligatorio.',
            'movement_type.required'  => 'El tipo de operación es obligatorio.',
            
            'category_id.required' => 'La categoría es obligatoria.',
            'category_id.integer'  => 'La categoría debe ser un número válido.',

            'subject.required' => 'El asunto es obligatorio.',
            'subject.string'   => 'El asunto debe ser un texto.',
            'subject.max'      => 'El asunto no puede superar los 75 caracteres.',

            'description.required' => 'La descripción es obligatoria.',
            'description.string'   => 'La descripción debe ser un texto.',
            'description.max'      => 'La descripción no puede superar los 255 caracteres.',

            'action_date.required' => 'La fecha es obligatoria.',
            'action_date.date'     => 'La fecha debe tener un formato válido.',

            'schedule.in' => 'El valor del campo de programación no es válido.',

            'expiration_date.required_if' => 'La fecha de expiración es obligatoria si se programa el ingreso.',
            'expiration_date.date'        => 'La fecha de expiración debe ser una fecha válida.',

            'period.required_if' => 'La recurrencia es obligatoria si se programa el ingreso.',
            'period.string'      => 'La recurrencia debe ser un texto.',
            'period.max'         => 'La recurrencia debe tener máximo un carácter.',

            'amount.required' => 'La cantidad es obligatoria.',
            'amount.numeric'  => 'La cantidad debe ser un número válido.',
        ];
    }

    


}
