<?php

namespace App\Validations;

class UserValidator extends Validator {

    protected static function rulesAdd(): array {
        return [
            'text' => 'required|string|max:255'
        ];
    }

    protected static function messagesAdd(): array {
        return [
            'text.required' => 'No se ha recibido el texto.',
            'text.string' => 'El tipo de dato no es correcto.',
            'text.max' => 'El tamaño del texto no concuerda con el permitido.'
        ];
    }

    protected static function rulesEdit(): array {
        return [
            'id' => 'required|integer',
            'text' => 'required|string|max:255'
        ];
    }

    protected static function messagesEdit(): array {
        return [
            'id.required' => 'Ha sucedido un error inesperado.',
            'id.integer' => 'Ha sucedido un error inesperado.',
            'text.required' => 'No se ha recibido el texto.',
            'text.string' => 'El tipo de dato no es correcto.',
            'text.max' => 'El tamaño del texto no concuerda con el permitido.'
        ];
    }

    protected static function rulesDelete(): array {
        return [
            'id' => 'required|integer'
        ];
    }

    protected static function messagesDelete(): array {
        return [
            'id.required' => 'Ha sucedido un error inesperado.',
            'id.integer' => 'Ha sucedido un error inesperado.',
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
            'objective' => 'sometimes|nullable|string|max:255',

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
}
