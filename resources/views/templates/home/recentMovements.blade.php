<div class="col-12 info-container mt-3 mt-lg-4 py-4 px-4">
    <h3 class="fs-4< fw-bold ">Movimientos recientes</h3>
    @foreach ($sixOperations as $operation)
        <div class="d-flex justify-content-between align-items-center">
            <p class="fs-5">{{ \Carbon\Carbon::parse($operation->action_date)->locale('es')->translatedFormat('j M') }} {{ $operation->category->name }}</p>
            <p class="{{ $operation->movement_type_id == 2 ? 'negative' : 'positive' }} fs-5">{{ $operation->movement_type_id == 2 ? '-' : '+' }}{{ $operation->amount }}</p>
        </div>
    @endforeach
</div> 