<?php

namespace App\Validations;

class ApiValidator extends Validator {

    protected static function rulesGetOperationById(): array {
        return [
            'id' => 'required|integer',
        ];
    }

    protected static function messagesGetOperationById(): array {
        return [
            'id.required' => 'Ha sucedido un error inesperado.',
            'id.integer' => 'Ha sucedido un error inesperado.',
        ];
    }

    protected static function rulesIncomeOperations(): array {
        return [
            'offset' => 'required|integer',
        ];
    }

    protected static function messagesIncomeOperations(): array {
        return [
            'offset.required' => 'El offset es necesario. Pongase en contacto con el equipo de soporte.',
            'offset.integer' => 'Ha sucedido un error inesperado. Pongase en contacto con el equipo de soporte.',
        ];
    }
}
