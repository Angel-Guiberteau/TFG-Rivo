<?php

namespace App\Validations;

class EndPointValidator extends Validator {

    protected static function rulesAdd(): array {
        return [
            'name' => 'required|string|max:75',
            'url' => 'required|string|max:255',
            'method' => 'required|string|max:7',
            'parameters' => 'nullable|string|max:75',
            'return' => 'required|string|max:15',
            'description' => 'nullable|string|max:255',
            'returnData' => 'required|string|max:255'
        ];
    }

    protected static function messagesAdd(): array {
        return [
            'name.required' => 'No se ha recibido el nombre.',
            'name.string' => 'El tipo de dato no es correcto.',
            'name.max' => 'El tamaño del nombre no concuerda con el permitido.',

            'url.required' => 'No se ha recibido la url.',
            'url.string' => 'El tipo de dato no es correcto.',
            'url.max' => 'El tamaño de la url no concuerda con el permitido.',

            'method.required' => 'No se ha recibido el metodo.',
            'method.string' => 'El tipo de dato no es correcto.',
            'method.max' => 'El tamaño del metodo no concuerda con el permitido.',
            
            'parameters.string' => 'El tipo de dato no es correcto.',
            'parameters.max' => 'El tamaño de los parametros no concuerda con el permitido.',
            
            'return.required' => 'No se ha recibido el retorno.',
            'return.string' => 'El tipo de dato no es correcto.',
            'return.max' => 'El tamaño del retorno no concuerda con el permitido.',
            
            'description.string' => 'El tipo de dato no es correcto.',
            'description.max' => 'El tamaño de la descripción no concuerda con el permitido.',

            'returnData.required' => 'No se han recibido los datos de retorno.',
            'returnData.string' => 'El tipo de dato no es correcto.',
            'returnData.max' => 'El tamaño del metodo no concuerda con el permitido.',
        ];
    }

    protected static function rulesEdit(): array {
        return [
            'id' => 'required|integer',
            'name' => 'required|string|max:75',
            'url' => 'required|string|max:255',
            'method' => 'required|string|max:7',
            'parameters' => 'nullable|string|max:75',
            'return' => 'required|string|max:15',
            'description' => 'nullable|string|max:255',
            'returnData' => 'required|string|max:255'
        ];
    }

    protected static function messagesEdit(): array {
        return [
            'id.required' => 'Ha sucedido un error inesperado.',
            'id.integer' => 'Ha sucedido un error inesperado.',

            'name.required' => 'No se ha recibido el nombre.',
            'name.string' => 'El tipo de dato no es correcto.',
            'name.max' => 'El tamaño del nombre no concuerda con el permitido.',

            'url.required' => 'No se ha recibido la url.',
            'url.string' => 'El tipo de dato no es correcto.',
            'url.max' => 'El tamaño de la url no concuerda con el permitido.',

            'method.required' => 'No se ha recibido el metodo.',
            'method.string' => 'El tipo de dato no es correcto.',
            'method.max' => 'El tamaño del metodo no concuerda con el permitido.',
            
            'parameters.string' => 'El tipo de dato no es correcto.',
            'parameters.max' => 'El tamaño de los parametros no concuerda con el permitido.',
            
            'return.required' => 'No se ha recibido el retorno.',
            'return.string' => 'El tipo de dato no es correcto.',
            'return.max' => 'El tamaño del retorno no concuerda con el permitido.',
            
            'description.string' => 'El tipo de dato no es correcto.',
            'description.max' => 'El tamaño de la descripción no concuerda con el permitido.',

            'returnData.required' => 'No se han recibido los datos de retorno.',
            'returnData.string' => 'El tipo de dato no es correcto.',
            'returnData.max' => 'El tamaño del metodo no concuerda con el permitido.',
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
