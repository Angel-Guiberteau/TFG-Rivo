// transactionInfo.js

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
        const res = await fetch(`/api/transaction/${id}`);
        const data = await res.json();

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
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.movement-row').forEach(row => {
        row.addEventListener('click', () => {
            const id = row.dataset.id;
            if (id) openTransactionDetail(id);
        });
    });
});