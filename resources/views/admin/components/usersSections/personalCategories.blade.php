<form method="POST" action="{{ route('updatePersonalCategories') }}">
    @csrf
    @method('PUT')

    <input type="hidden" id="deletedCategories" name="deleted" value="[]">
    <input type="hidden" name="user_id" value="{{ $user->id }}">

    <div id="categoryContainer" class="row mb-4">
        @foreach($personalCategories as $index => $category)
            @include('admin.components.userPartials.categoryBlock', ['index' => $index, 'category' => $category, 'allIcons' => $allIcons, 'movementTypes' => $movementTypes])
        @endforeach
    </div>

    <div class="text-end">
        <button type="button" class="btn btn-success btn-sm" id="addCustomCategoryBtn">
            <i class="fa-solid fa-plus"></i>
        </button>
        <button type="submit" class="btn btn-primary btn-sm">
            <i class="fa-solid fa-floppy-disk"></i>
        </button>
        <a href="{{ route('users') }}" class="btn btn-danger btn-sm">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
    </div>
</form>
