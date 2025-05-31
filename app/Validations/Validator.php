<?php

namespace App\Validations;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator as LaravelValidator;

abstract class Validator extends Controller
{
    public static function validate(array $data, string $option): array {
        $rules = static::getRules($option);
        $messages = static::getMessages($option);

        $validator = LaravelValidator::make($data, $rules, $messages);

        if ($validator->fails()) {
            return [
                'status' => false,
                'error' => $validator->errors()->all(),
            ];
        }

        return [
            'status' => true,
            'data' => $validator->validated(),
        ];
    }

    private static function getRules(string $option): array {
        return match ($option) {
            'add' => static::rulesAdd(),
            'edit' => static::rulesEdit(),
            'delete' => static::rulesDelete(),
            'initialSetup' => static::rulesInitialSetup(),
            'updatePersonalCategories' => static::rulesUpdatePersonalCategories(),
            default => [],
        };
    }

    private static function getMessages(string $option): array {
        return match ($option) {
            'add' => static::messagesAdd(),
            'edit' => static::messagesEdit(),
            'delete' => static::messagesDelete(),
            'initialSetup' => static::messagesInitialSetup(),
            'updatePersonalCategories' => static::messagesUpdatePersonalCategories(),
            default => [],
        };
    }

    protected static function rulesAdd(): array { return []; }
    protected static function messagesAdd(): array { return []; }
    protected static function rulesEdit(): array { return []; }
    protected static function messagesEdit(): array { return []; }
    protected static function rulesDelete(): array { return []; }
    protected static function messagesDelete(): array { return []; }
    protected static function rulesInitialSetup(): array { return []; }
    protected static function messagesInitialSetup(): array { return []; }
    protected static function rulesUpdatePersonalCategories(): array { return []; }
    protected static function messagesUpdatePersonalCategories(): array { return []; }
    // protected static function rulesPreView(): array { return []; }
    // protected static function messagesPreView(): array { return []; }
}
