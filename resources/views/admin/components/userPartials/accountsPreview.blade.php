<div class="card mt-4">
    <div class="card-header bg-primary">
        <i class="fas fa-wallet me-2"></i>Cuentas del Usuario
    </div>
    <div class="card-body">
        <div class="row gy-4">
            @forelse($personalAccounts as $account)
                <div class="col-md-6 col-lg-4">
                    <div class="card account-card h-100">
                        <div class="card-body">
                            <h5 class="card-title mb-2 p-2 rounded">
                                <i class="fas fa-university me-2"></i>{{ $account->name }}
                            </h5>
                            <p class="mb-1"><strong>ID:</strong> {{ $account->id }}</p>
                            <p class="mb-1"><strong>Saldo:</strong> 
                                <span class="fw-semibold">{{ number_format($account->balance, 2) }} {{ $account->currency }}</span>
                            </p>
                            <p class="mb-1">
                                <strong>Estado:</strong>
                                <span class="badge-status bg-{{ $account->enabled ? 'success' : 'danger' }}">
                                    {{ $account->enabled ? 'Activo' : 'Inactivo' }}
                                </span>
                            </p>
                            <p class="mb-1"><strong>Creada:</strong> {{ \Carbon\Carbon::parse($account->created_at)->format('d/m/Y H:i') }}</p>
                            <p class="mb-0"><strong>Actualizada:</strong> {{ \Carbon\Carbon::parse($account->updated_at)->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-muted">No hay cuentas personales asociadas.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>