<div class="col-12 movement-block mt-3 mt-lg-4 py-4 px-4">
    <h3 class="section-title">Movimientos recientes</h3>
    <div class="row">
        @foreach ($sixOperations as $index => $operation)
            <div class="col-12 col-lg-6 {{ $index % 2 === 0 ? 'border-lg-end' : '' }}">
                <div class="movement-row">
                    <div class="d-flex align-items-center gap-3">
                        <div class="movement-icon">
                            {!! $operation->category->icon->icon !!}
                        </div>
                        <div class="movement-info">
                            <p class="movement-date mb-0">
                                {{ \Carbon\Carbon::parse($operation->action_date)->locale('es')->translatedFormat('j M') }}
                            </p>
                            <p class="badge mb-1 
                                {{ $operation->movement_type_id == 1 ? 'badge-income' : 
                                ($operation->movement_type_id == 2 ? 'badge-expense' : 
                                ($operation->movement_type_id == 3 ? 'badge-save' : '') ) }}">
                                {{ $operation->movement_type_id == 1 ? 'Ingreso' : 
                                ($operation->movement_type_id == 2 ? 'Gasto' : 
                                ($operation->movement_type_id == 3 ? 'Ahorro' : '') ) }}
                            </p>
                            <p class="movement-name mb-0">{{ $operation->category->name }}</p>
                        </div>
                    </div>
                    <p class="movement-amount m-0 pe-2 fs-5 {{ $operation->movement_type_id == 2 ? 'negative' : 'positive' }}">
                        {{ $operation->movement_type_id == 2 ? '-' : '+' }}{{ number_format($operation->amount, 2) }}€
                    </p>
                </div>
            </div>
        @endforeach
    </div>
</div>
