<form method="POST" action="{{ route('updatePersonalAccounts') }}">
    @csrf
    @method('PUT')

    <input type="hidden" id="deletedAccounts" name="deleted" value="[]">
    <input type="hidden" name="user_id" value="{{ $user->id }}">

    <div id="accountsContainer" class="row mb-4">
        @foreach($personalAccounts as $index => $account)
            @include('admin.components.userPartials.accountBlock', ['index' => $index, 'account' => $account])
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
