<div class="col-12 card-section mt-4">
    <h3 class="section-title">
        Resumen de {{ ucfirst(\Carbon\Carbon::now()->locale('es')->translatedFormat('F Y')) }}
    </h3>
    <div class="d-flex flex-column flex-lg-row gap-4">
        <div class="w-100">
            <h4 class="section-title fs-5">Ingresos</h4>
            @foreach ($thisMonthIncomes as $operation)
                <div class="list-entry">
                    <div class="entry-icon">{!! $operation['icon'] !!}</div>
                    <div class="flex-grow-1">
                        <span class="entry-label">{{ $operation['category_name'] }}</span>
                    </div>
                    <div class="fs-5 entry-value income-color">
                        {{ number_format($operation['total_amount'], 2) }}€
                    </div>
                </div>
            @endforeach
            <canvas id="incomeChart" height="200" class="my-4"></canvas>
        </div>

        <div class="w-100">
            <h4 class="section-title fs-5">Gastos</h4>
            @foreach ($thisMonthExpenses as $operation)
                <div class="list-entry">
                    <div class="entry-icon">{!! $operation['icon'] !!}</div>
                    <div class="flex-grow-1">
                        <span class="entry-label">{{ $operation['category_name'] }}</span>
                    </div>
                    <div class="fs-5 entry-value {{ $operation['movement_type_id'] == 2 ? 'expense-color' : 'save-color' }}">
                        {{ number_format($operation['total_amount'], 2) }}€
                    </div>
                </div>
            @endforeach
            <canvas id="expenseChart" height="200" class="my-4"></canvas>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const incomeCtx = document.getElementById('incomeChart');
        const expenseCtx = document.getElementById('expenseChart');

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
                    borderWidth: 0
                }]
            },
            options: {
                cutout: '70%',
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // === GASTOS / AHORRO ===
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
                    borderWidth: 0
                }]
            },
            options: {
                cutout: '70%',
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    });
</script>