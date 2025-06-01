<?php

namespace App\Validations;

class IconValidator extends Validator {

    protected static function rulesAdd(): array {
        return [
            'name' => 'required|string',
        ];
    }

    protected static function messagesAdd(): array {
        return [
            'name.required' => 'No se ha recibido el texto.',
            'name.string' => 'El tipo de dato no es correcto.',
        ];
    }

    protected static function rulesEdit(): array {
        return [
            'id' => 'required|integer',
            'name' => 'required|string',
        ];
    }

    protected static function messagesEdit(): array {
        return [
            'id.required' => 'Ha sucedido un error inesperado.',
            'id.integer' => 'Ha sucedido un error inesperado.',
            'name.required' => 'No se ha recibido el texto.',
            'name.string' => 'El tipo de dato no es correcto.',
        ];
    }

    protected static function rulesDelete(): array {
        return [
            'id' => 'required|integer',
        ];
    }

    protected static function messagesDelete(): array {
        return [
            'id.required' => 'Ha sucedido un error inesperado.',
            'id.integer' => 'Ha sucedido un error inesperado.',
        ];
    }
}
