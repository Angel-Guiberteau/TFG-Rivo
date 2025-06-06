document.addEventListener("DOMContentLoaded", function () {
    const incomeCtx = document.getElementById('incomeChart');
    const expenseCtx = document.getElementById('expenseChart');

    if (!window.chartData) return;

    const incomeData = window.chartData.incomes || [];
    const expenseData = window.chartData.expenses || [];

    const incomeLabels = incomeData.map(op => op.category_name);
    const incomeAmounts = incomeData.map(op => op.total_amount);

    const expenseLabels = expenseData.map(op => op.category_name);
    const expenseAmounts = expenseData.map(op => op.total_amount);

    const COLORS = [
        'rgba(107, 0, 229, 0.75)',
        'rgba(142, 45, 226, 0.65)',
        'rgba(161, 102, 230, 0.55)',
        'rgba(201, 164, 236, 0.45)',
        'rgba(233, 216, 253, 0.35)'
    ];

    if (incomeCtx) {
        new Chart(incomeCtx, {
            type: 'doughnut',
            data: {
                labels: incomeLabels,
                datasets: [{
                    data: incomeAmounts,
                    backgroundColor: COLORS,
                    borderWidth: 0
                }]
            },
            options: {
                cutout: '70%',
                plugins: { legend: { display: false } }
            }
        });
    }

    if (expenseCtx) {
        new Chart(expenseCtx, {
            type: 'doughnut',
            data: {
                labels: expenseLabels,
                datasets: [{
                    data: expenseAmounts,
                    backgroundColor: COLORS,
                    borderWidth: 0
                }]
            },
            options: {
                cutout: '70%',
                plugins: { legend: { display: false } }
            }
        });
    }
});
