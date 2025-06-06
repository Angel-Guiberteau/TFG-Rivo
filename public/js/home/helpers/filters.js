export function setupGlobalSearch(type) {
    const searchInput = document.getElementById(`${type}-search`);
    const movementContainer = document.getElementById(`${type}-movements`);
    if (!searchInput || !movementContainer) return;

    searchInput.addEventListener('input', () => {
        const query = searchInput.value.toLowerCase();
        const rows = movementContainer.querySelectorAll('.movement-row');
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(query) ? '' : 'none';
        });
    });
}
