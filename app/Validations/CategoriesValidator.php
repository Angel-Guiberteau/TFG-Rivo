<?php

namespace App\Validations;

class CategoriesValidator extends Validator {

    protected static function rulesAdd(): array {
        return [
            'name' => 'required|string|max:75'
        ];
    }

    protected static function messagesAdd(): array {
        return [
            'name.required' => 'No se ha recibido el texto.',
            'name.string' => 'El tipo de dato no es correcto.',
            'name.max' => 'El tamaño del texto no concuerda con el permitido.'
        ];
    }

    protected static function rulesEdit(): array {
        return [
            'id' => 'required|integer',
            'name' => 'required|string|max:75'
        ];
    }

    protected static function messagesEdit(): array {
        return [
            'id.required' => 'Ha sucedido un error inesperado.',
            'id.integer' => 'Ha sucedido un error inesperado.',
            'name.required' => 'No se ha recibido el texto.',
            'name.string' => 'El tipo de dato no es correcto.',
            'name.max' => 'El tamaño del texto no concuerda con el permitido.'
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
            'name' => 'required|string|max:75'
        ];
    }

    protected static function messagesPreView(): array {
        return [
            'name.required' => 'No se ha recibido el texto.',
            'name.string' => 'El tipo de dato no es correcto.',
            'name.max' => 'El tamaño del texto no concuerda con el permitido.'
        ];
    }
}
