<?php

namespace App\Validations;

class SentencesValidator extends Validator {

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
}
