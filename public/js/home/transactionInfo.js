import { fetchData } from './helpers/api.js';
import { refreshRecentOperations } from './helpers/api.js';
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.movement-row').forEach(row => {
        row.addEventListener('click', () => {
            const id = row.dataset.id;
            if (id) openTransactionDetail(id);
        });
    });
});
function getBadgeText(typeId) {
    switch (typeId) {
        case 1: return 'Ingreso';
        case 2: return 'Gasto';
        case 3: return 'Ahorro';
        default: return '';
    }
}

function getBadgeClass(typeId) {
    switch (typeId) {
        case 1: return 'income';
        case 2: return 'expense';
        case 3: return 'save';
        default: return '';
    }
}

function getRecurrenceText(code) {
    switch (code) {
        case 'd': return 'Diario';
        case 'w': return 'Semanal';
        case 'm': return 'Mensual';
        default: return 'Otro';
    }
}

function formatDate(dateStr) {
    if (!dateStr) return 'Sin fecha';
    const date = new Date(dateStr);
    const day = date.getDate();
    const month = date.toLocaleString('es-ES', { month: 'long' });
    const year = date.getFullYear();
    const hours = date.getHours().toString().padStart(2, '0');
    const minutes = date.getMinutes().toString().padStart(2, '0');
    return `${day} ${month} ${year} - ${hours}:${minutes}`;
}

export async function openTransactionDetail(id) {
    const panel = document.getElementById('transactionDetail');
    if (!panel) return;

    try {
        const data = await fetchData(`/api/operation/transaction/${id}`);
        if (!data) return;

        document.querySelector('.icon-circle-light').innerHTML = data.icon_html;
        document.querySelector('.tx-title').textContent = data.subject;

        const badge = document.querySelector('.badge-light');
        badge.textContent = getBadgeText(data.movement_type_id);
        badge.className = 'badge-light ' + getBadgeClass(data.movement_type_id);

        document.querySelector('#tx-description .tx-value').textContent = data.description;
        document.querySelector('#tx-category .tx-value').textContent = data.category_name ?? '—';

        const amountEl = document.querySelector('#tx-amount .tx-value');
        amountEl.textContent = `${data.amount > 0 ? '+' : ''}${parseFloat(data.amount).toFixed(2)}€`;
        amountEl.className = 'tx-value ' + (data.amount > 0 ? 'positive' : 'negative');

        document.querySelector('#tx-date .tx-value').textContent = formatDate(data.action_date);

        const recurrenteEl = document.getElementById('tx-recurrente');
        if (data.is_recurrent) {
            recurrenteEl.style.display = 'block';
            recurrenteEl.querySelector('.tx-value').textContent = 'Sí';
            const subs = recurrenteEl.querySelectorAll('.tx-sub .tx-value');
            subs[0].textContent = formatDate(data.start_date);
            subs[1].textContent = formatDate(data.expiration_date);
            subs[2].textContent = getRecurrenceText(data.recurrence);
        } else {
            recurrenteEl.style.display = 'none';
        }
        const deleteBtn = document.querySelector('.btn-full.delete');
        if (deleteBtn) {
            deleteBtn.onclick = () => {
                swal({
                    title: "¿Eliminar transacción?",
                    text: "Esta acción no se puede deshacer.",
                    icon: "warning",
                    buttons: ["Cancelar", "Sí, eliminar"],
                    dangerMode: true
                }).then(async (willDelete) => {
                    if (!willDelete) return;

                    try {
                        const res = await fetch(`/api/operation/deleteOperation/${id}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Content-Type': 'application/json'
                            }
                        });

                        if (!res.ok) throw new Error('Error al eliminar');

                        const row = document.querySelector(`.movement-row[data-id="${id}"]`);
                        if (row) row.closest('.movement-item').remove();

                        closePanel();
                        refreshRecentOperations();

                        const visibleSection = document.querySelector('article.show');
                        if (visibleSection?.id?.includes('section')) {
                            const sectionType = visibleSection.id.replace('-section', '');
                            refreshHistory(sectionType);
                        }

                        swal("Transacción eliminada correctamente", {
                            icon: "success",
                            timer: 2000,
                            buttons: false
                        });

                    } catch (error) {
                        console.error(error);
                        swal("Error al eliminar la transacción", {
                            icon: "error"
                        });
                    }
                });
            };

        }

        const editOperationButton = document.getElementById('editOperationButton');
        if (editOperationButton) {
            editOperationButton.onclick = () => {
                closePanel();

                document.querySelectorAll('article').forEach(section => section.classList.remove('show'));

                const formSection = document.getElementById('operationAddForm-section');
                formSection?.classList.add('show');
                formSection?.scrollIntoView({ behavior: 'smooth' });

                if (data.movement_type_id === 1) {
                    document.getElementById('op-income')?.click();
                } else if (data.movement_type_id === 2) {
                    document.getElementById('op-expense')?.click();
                } else if (data.movement_type_id === 3) {
                    document.getElementById('op-save')?.click();
                }

                setTimeout(() => fillEditForm(data), 100);
            };
        }
        openPanel();

    } catch (error) {
        console.error('Error al cargar transacción:', error);
    }
}

function openPanel() {
    const panel = document.getElementById('transactionDetail');
    if (!panel) return;
    panel.classList.add('show');
    panel.classList.remove('hidden');
    document.body.classList.add('no-scroll', 'blur-active');
}

export function closePanel() {
    const panel = document.getElementById('transactionDetail');
    if (!panel) return;
    panel.classList.remove('show');
    document.body.classList.remove('no-scroll', 'blur-active');
    setTimeout(() => {
        panel.classList.add('hidden');
    }, 400);
}

window.closePanel = closePanel;


