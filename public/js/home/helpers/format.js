export function formatDate(dateStr) {
    if (!dateStr) return 'Sin fecha';
    const date = new Date(dateStr);
    const day = date.getDate();
    const month = date.toLocaleString('es-ES', { month: 'long' });
    const year = date.getFullYear();
    const hours = date.getHours().toString().padStart(2, '0');
    const minutes = date.getMinutes().toString().padStart(2, '0');
    return `${day} ${month} ${year} - ${hours}:${minutes}`;
}

export function formatShortDate(dateStr) {
    const date = new Date(dateStr);
    const day = date.getDate();
    const month = date.toLocaleString('es-ES', { month: 'short' }).replace('.', '');
    return `${day} ${month}.`;
}

export function getBadgeText(typeId) {
    switch (typeId) {
        case 1: return 'Ingreso';
        case 2: return 'Gasto';
        case 3: return 'Ahorro';
        default: return '';
    }
}

export function getBadgeClass(typeId) {
    switch (typeId) {
        case 1: return 'income';
        case 2: return 'expense';
        case 3: return 'save';
        default: return '';
    }
}

export function getRecurrenceText(code) {
    switch (code) {
        case 'd': return 'Diario';
        case 'w': return 'Semanal';
        case 'm': return 'Mensual';
        default: return 'Otro';
    }
}
export function getMovementLabel(typeId) {
    switch (typeId) {
        case 1: return 'Ingreso';
        case 2: return 'Gasto';
        case 3: return 'Ahorro';
        default: return '';
    }
}

