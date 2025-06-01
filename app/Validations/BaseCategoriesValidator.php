<?php

namespace App\Validations;

class BaseCategoriesValidator extends Validator {

    protected static function rulesAdd(): array {
        return [
            'name' => 'required|string|max:30',
            'types' => 'required|array',
            'types.*' => 'required|integer',
            'icon' => 'required|integer',
        ];
    }

    protected static function messagesAdd(): array {
        return [
            'name.required' => 'No se ha recibido el texto.',
            'name.string' => 'El tipo de dato no es correcto.',
            'name.max' => 'El tamaño del texto no concuerda con el permitido.',
            'types.required' => 'No se ha recibido el tipo.',
            'types.array' => 'Ha sucedido un error inesperado.',
            'types.*.required' => 'El tipo es necesario introducirlo.',
            'types.*.integer' => 'Ha sucedido un error inesperado.',
            'icon.required' => 'El icono es necesario seleccionarlo.',
            'icon.integer' => 'Ha sucedido un error inesperado.',
        ];
    }

    protected static function rulesEdit(): array {
        return [
            'id' => 'required|integer',
            'name' => 'required|string|max:30',
            'types' => 'required|array',
            'types.*' => 'required|integer',
            'icon' => 'required|integer',
        ];
    }

    protected static function messagesEdit(): array {
        return [
            'id.required' => 'Ha sucedido un error inesperado.',
            'id.integer' => 'Ha sucedido un error inesperado.',
            'name.required' => 'No se ha recibido el texto.',
            'name.string' => 'El tipo de dato no es correcto.',
            'name.max' => 'El tamaño del texto no concuerda con el permitido.',
            'types.required' => 'No se ha recibido el tipo.',
            'types.array' => 'Ha sucedido un error inesperado.',
            'types.*.required' => 'El tipo es necesario introducirlo.',
            'types.*.integer' => 'Ha sucedido un error inesperado.',
            'icon.required' => 'El icono es necesario seleccionarlo.',
            'icon.integer' => 'Ha sucedido un error inesperado.',
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
