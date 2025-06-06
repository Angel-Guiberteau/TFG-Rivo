<style>
    .chart-wrapper {
        position: relative;
        overflow: visible;
        z-index: 2;
    }

    .card-section,
    .list-div-entry,
    .d-flex,
    .col-12 {
        overflow: visible !important;
    }
</style>

@if (isset($thisMonthIncomes) && $thisMonthIncomes->isnotEmpty())
    <div class="col-12 card-section mt-4">
        <h3 class="section-title">
            Resumen de ingresos de {{ ucfirst(\Carbon\Carbon::now()->locale('es')->translatedFormat('F Y')) }}
        </h3>
        <div class="w-100">
            <div class="d-flex flex-column flex-lg-row gap-4">
                <div class="list-div-entry w-100">
                    @foreach ($thisMonthIncomes as $operation)
                        <div class="list-entry w-100">
                            <div class="entry-icon">{!! $operation['icon'] !!}</div>
                            <div class="flex-grow-1 w-100">
                                <span class="entry-label">{{ $operation['category_name'] }}</span>
                            </div>
                            <div class="fs-5 entry-value income-color">
                                {{ number_format($operation['total_amount'], 2) }}€
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-center align-items-center flex-grow-1 chart-wrapper" style="min-height: 200px;">
                    <div style="width: 260px;">
                        <canvas id="incomeChart" class="w-100 h-auto"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

@if (isset($thisMonthExpenses) && $thisMonthExpenses->isnotEmpty())
    <div class="col-12 card-section mt-4">
        <h3 class="section-title">
            Resumen de gastos de {{ ucfirst(\Carbon\Carbon::now()->locale('es')->translatedFormat('F Y')) }}
        </h3>
        <div class="w-100">
            <div class="d-flex flex-column flex-lg-row gap-4">
                <div class="list-div-entry w-100">
                    @foreach ($thisMonthExpenses as $operation)
                        <div class="list-entry w-100">
                            <div class="entry-icon">{!! $operation['icon'] !!}</div>
                            <div class="flex-grow-1 w-100">
                                <span class="entry-label">{{ $operation['category_name'] }}</span>
                            </div>
                            <div class="fs-5 entry-value {{ $operation['movement_type_id'] == 2 ? 'expense-color' : 'save-color' }}">
                                {{ number_format($operation['total_amount'], 2) }}€
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-center align-items-center flex-grow-1 chart-wrapper" style="min-height: 200px;">
                    <div style="width: 260px;">
                        <canvas id="expenseChart" class="w-100 h-auto"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const incomeCtx = document.getElementById('incomeChart');
        const expenseCtx = document.getElementById('expenseChart');

        const centerTextPlugin = {
            id: 'centerText',
            beforeDraw(chart) {
                const { width, height, ctx } = chart;
                const dataset = chart.data.datasets[0];
                const total = dataset.data.reduce((a, b) => a + b, 0);

                ctx.save();
                ctx.font = 'bold 18px sans-serif';
                ctx.fillStyle = '#6b00e5';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                ctx.fillText("💶", width / 2, height / 2 - 12);
                ctx.fillText(total + '€', width / 2, height / 2 + 10);
                ctx.restore();
            }
        };

        const getOptions = () => ({
            responsive: true,
            maintainAspectRatio: false,
            cutout: '70%',
            layout: {
                padding: 10
            },
            animation: {
                animateRotate: true,
                animateScale: true,
                duration: 1000,
                easing: 'easeOutQuart'
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            const total = context.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                            const value = context.parsed;
                            const percent = ((value / total) * 100).toFixed(1);
                            return `${context.label}: ${value}€ (${percent}%)`;
                        }
                    }
                }
            }
        });

        // === INGRESOS ===
        new Chart(incomeCtx, {
            type: 'doughnut',
            data: {
                labels: [
                    @foreach ($thisMonthIncomes as $op)
                        "{{ $op['category_name'] }}",
                    @endforeach
                ],
                datasets: [{
                    data: [
                        @foreach ($thisMonthIncomes as $op)
                            {{ $op['total_amount'] }},
                        @endforeach
                    ],
                    backgroundColor: [
                        'rgba(107, 0, 229, 0.75)',
                        'rgba(142, 45, 226, 0.65)',
                        'rgba(161, 102, 230, 0.55)',
                        'rgba(201, 164, 236, 0.45)',
                        'rgba(233, 216, 253, 0.35)'
                    ],
                    borderColor: '#fff',
                    borderWidth: 2,
                    hoverOffset: 10
                }]
            },
            options: getOptions(),
            plugins: [centerTextPlugin]
        });

        // === GASTOS ===
        new Chart(expenseCtx, {
            type: 'doughnut',
            data: {
                labels: [
                    @foreach ($thisMonthExpenses as $op)
                        "{{ $op['category_name'] }}",
                    @endforeach
                ],
                datasets: [{
                    data: [
                        @foreach ($thisMonthExpenses as $op)
                            {{ $op['total_amount'] }},
                        @endforeach
                    ],
                    backgroundColor: [
                        'rgba(107, 0, 229, 0.75)',
                        'rgba(142, 45, 226, 0.65)',
                        'rgba(161, 102, 230, 0.55)',
                        'rgba(201, 164, 236, 0.45)',
                        'rgba(233, 216, 253, 0.35)'
                    ],
                    borderColor: '#fff',
                    borderWidth: 2,
                    hoverOffset: 10
                }]
            },
            options: getOptions(),
            plugins: [centerTextPlugin]
        });
    });
</script>


