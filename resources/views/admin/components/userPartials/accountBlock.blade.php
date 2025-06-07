<div class="col-md-6 col-lg-4 mb-4 account-card" data-id="{{ $account['id'] ?? '' }}" data-index="{{ $index }}">
    <div class="card h-100 rounded shadow overflow-hidden">
        <div class="card-body p-4 bg-white">
            <input type="hidden" name="accounts[{{ $index }}][id]" value="{{ $account['id'] ?? '' }}">

            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 delete-account-btn"
                data-id="{{ $account['id'] ?? '' }}" data-existing="{{ isset($account['id']) ? 'true' : 'false' }}">
                <i class="fa-solid fa-trash"></i>
            </button>

            <div class="mb-3">
                <label class="form-label fw-medium text-muted">Nombre de la cuenta <span class="text-danger">*</span></label>
                <input type="text" name="accounts[{{ $index }}][name]" class="form-control text-center"
                    value="{{ old("accounts.$index.name", $account['name'] ?? '') }}">
            </div>

            <div class="mb-3">
                <label class="form-label fw-medium text-muted">Saldo <span class="text-danger">*</span></label>
                <input type="number" step="0.01" name="accounts[{{ $index }}][balance]" class="form-control text-center"
                    value="{{ old("accounts.$index.balance", $account['balance'] ?? '') }}">
            </div>

            <div class="mb-3">
                <label class="form-label fw-medium text-muted">Moneda <span class="text-danger">*</span></label>
                <input type="text" name="accounts[{{ $index }}][currency]" class="form-control text-center"
                    value="{{ old("accounts.$index.currency", $account['currency'] ?? '') }}">
            </div>

            <div class="form-check form-switch text-center">
                <input class="form-check-input" type="checkbox" role="switch" id="enabledSwitch{{ $index }}"
                    name="accounts[{{ $index }}][enabled]" value="1"
                    {{ old("accounts.$index.enabled", $account['enabled'] ?? false) ? 'checked' : '' }}>
                <label class="form-check-label" for="enabledSwitch{{ $index }}">Habilitada</label>
            </div>
        </div>
    </div>
</div>
