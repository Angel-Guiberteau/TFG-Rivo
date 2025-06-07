<form method="POST" action="{{ route('updatePersonalAccounts') }}">
    @csrf
    @method('PUT')
    <input type="hidden" id="deletedAccounts" name="deleted" value="[]">
    <input type="hidden" name="user_id" value="{{ $user->id }}">

    <div id="accountsContainer" class="row mb-4">
        @foreach($personalAccounts as $account)
            <div class="col-md-6 col-lg-4 mb-4 account-card" data-id="{{ $account->id }}">
                <div class="card h-100 rounded shadow overflow-hidden">
                    <div class="card-body p-4 bg-white">
                        <input type="hidden" name="accounts[{{ $account->id }}][id]" value="{{ $account->id }}">

                        <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 delete-account-btn" data-id="{{ $account->id }}" data-existing="true">
                            <i class="fa-solid fa-trash"></i>
                        </button>

                        <div class="mb-3">
                            <label class="form-label fw-medium text-muted">Nombre de la cuenta <span class="text-danger">*</span></label>
                            <input type="text" name="accounts[{{ $account->id }}][name]" class="form-control text-center" value="{{ $account->name }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-medium text-muted">Saldo <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="accounts[{{ $account->id }}][balance]" class="form-control text-center" value="{{ $account->balance }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-medium text-muted">Moneda <span class="text-danger">*</span></label>
                            <input type="text" name="accounts[{{ $account->id }}][currency]" class="form-control text-center" value="{{ $account->currency }}">
                        </div>

                        <div class="form-check form-switch text-center">
                            <input class="form-check-input" type="checkbox" role="switch" id="enabledSwitch{{ $account->id }}" name="accounts[{{ $account->id }}][enabled]" value="1" {{ $account->enabled ? 'checked' : '' }}>
                            <label class="form-check-label" for="enabledSwitch{{ $account->id }}">Habilitada</label>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="text-end">
        <button type="button" class="btn btn-success btn-sm" id="addAccountBtn">
            <i class="fa-solid fa-plus"></i>
        </button>
        <button type="submit" class="btn btn-primary btn-sm" id="saveAccountsBtn">
            <i class="fa-solid fa-floppy-disk"></i>
        </button>
        <a href="{{ route('users') }}" class="btn btn-danger btn-sm">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
    </div>
</form>