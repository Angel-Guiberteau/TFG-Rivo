<?php

namespace App\Enums;

enum ValidationEnum: string
{
    case ADD = 'add';
    case EDIT = 'edit';
    case DELETE = 'delete';
    case INITIALSETUP = 'initialSetup';
    case UPDATE_PERSONAL_CATEGORIES = 'updatePersonalCategories';
    case UPDATE_PERSONAL_ACOUNTS = 'updatePersonalAccounts';
    case ADD_OPERATION_USER = 'addIncomeUser';
    case GET_OPERATION_BY_ID = 'getOperationById';
    case INCOME_OPERATIONS = 'incomeOperations';
    case DELETE_OPERATION = 'deleteOperation';
}
