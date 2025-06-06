<div class="col-12 card-section mt-4">
    <h3 class="section-title">
        Resumen de {{ ucfirst(\Carbon\Carbon::now()->locale('es')->translatedFormat('F Y')) }}
    </h3>
    <div class="w-100">
        <h4 class="section-title fs-5">Ingresos</h4>
        <div class="d-flex  flex-column flex-lg-row gap-4">
            <div>
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
            </div>
            <canvas id="expenseChart" height="200" class="my-4"></canvas>
        </div>
    </div>
</div>
