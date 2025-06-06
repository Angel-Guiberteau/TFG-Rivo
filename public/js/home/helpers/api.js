import { formatShortDate, getBadgeClass, getMovementLabel } from './format.js';
import { attachPanelEvents } from '../ui/panel.js';

export async function fetchData(url, method = 'GET', body = null) {
    const headers = {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    };

    const options = { method, headers };

    if (body && method !== 'GET') {
        options.body = JSON.stringify(body);
    }

    try {
        const res = await fetch(url, options);
        if (!res.ok) throw new Error(`Error ${res.status}: ${res.statusText}`);
        return await res.json();
    } catch (err) {
        return null;
    }
}
export async function refreshRecentOperations() {
    const container = document.querySelector('#recentOperations');
    if (!container) return;

    try {
        const res = await fetch('/api/operation/refreshRecentOperations');
        const operations = await res.json();
        console.log(operations);

        container.innerHTML = '';

        operations.forEach((op, index) => {
            const movementHTML = `
                <div class="col-12 col-lg-6 ${index % 2 === 0 ? 'border-lg-end' : ''}">
                    <div class="movement-item">
                        <div class="movement-row" data-id="${op.id}">
                            <div class="movement-left d-flex align-items-center gap-3">
                                <div class="movement-icon">${op.category.icon.icon}</div>
                                <div class="movement-info">
                                    <p class="movement-date mb-0">${formatShortDate(op.action_date)}</p>
                                    <p class="badge-${getBadgeClass(op.movement_type_id)} mb-1 ">
                                        ${getMovementLabel(op.movement_type_id)}
                                    </p>
                                    <p class="movement-name mb-0">${op.category.name}</p>
                                </div>
                            </div>
                            <div class="movement-right">
                                <p class="movement-amount m-0 fs-5 ${op.movement_type_id == 2 ? 'negative' : 'positive'}">
                                    ${op.movement_type_id == 2 ? '-' : '+'}${Number(op.amount).toFixed(2)}€
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', movementHTML);
        });

        attachPanelEvents();

    } catch (e) {
        console.error('Error al actualizar movimientos recientes:', e);
    }
}
