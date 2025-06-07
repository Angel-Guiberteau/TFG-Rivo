<?php

namespace App\Enums;

/**
 * Enum ValidationEnum
 *
 * Enum que representa los distintos contextos de validación usados en el sistema.
 */
enum ValidationEnum: string
{
    /** Validación para añadir un nuevo recurso */
    case ADD = 'add';

    /** Validación para editar un recurso existente */
    case EDIT = 'edit';

    /** Validación para eliminar un recurso */
    case DELETE = 'delete';

    /** Validación para el proceso de configuración inicial del usuario */
    case INITIALSETUP = 'initialSetup';

    /** Validación para actualizar categorías personales del usuario */
    case UPDATE_PERSONAL_CATEGORIES = 'updatePersonalCategories';

    /** Validación para actualizar cuentas personales del usuario */
    case UPDATE_PERSONAL_ACOUNTS = 'updatePersonalAccounts';

    /** Validación para actualizar objetivos personales del usuario */
    case UPDATE_PERSONAL_OBJETIVES = 'updatePersonalObjetives';

    /** Validación para añadir una operación de ingreso del usuario */
    case ADD_OPERATION_USER = 'addIncomeUser';

    /** Validación que solo requiere verificar el ID */
    case VALIDATE_ID_ONLY = 'validateIdOnly';

    /** Validación para obtener operaciones con paginación por offset */
    case GET_OPERATIONS_OFFSET = 'incomeOperations';
}
