import { openTransactionDetail } from '../transactionInfo.js';

export function openPanel() {
    const panel = document.getElementById('transactionDetail');
    if (!panel) return;
    panel.classList.add('show');
    panel.classList.remove('hidden');
    document.body.classList.add('no-scroll', 'blur-active');
}
document.addEventListener('click', function (event) {
    const panel = document.getElementById('transactionDetail');

    if (
        panel &&
        panel.classList.contains('show') &&
        !panel.contains(event.target) &&
        !event.target.closest('.movement-row')
    ) {
        closePanel();
    }
});
export function closePanel() {
    const panel = document.getElementById('transactionDetail');
    if (!panel) return;
    panel.classList.remove('show');
    document.body.classList.remove('no-scroll', 'blur-active');
    setTimeout(() => {
        panel.classList.add('hidden');
    }, 400);
}

export function attachPanelEvents() {
    document.querySelectorAll('.movement-row').forEach(row => {
        row.addEventListener('click', () => {
            const id = row.dataset.id;
            if (id) openTransactionDetail(id);
        });
    });
}

window.closePanel = closePanel;
