<?php

namespace App\Enums;

enum ValidationEnum: string
{
    case ADD = 'add';
    case EDIT = 'edit';
    case DELETE = 'delete';
    case INITIALSETUP = 'initialSetup';
    case UPDATE_PERSONAL_CATEGORIES = 'updatePersonalCategories';
    // case PREVIEW = 'preView';
}
