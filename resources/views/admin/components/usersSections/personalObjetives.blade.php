<form method="POST" action="" id="objectivesForm" class="needs-validation" novalidate>
    @csrf
    @method('PUT')

    <div class="accordion" id="objectivesAccordion">
        @foreach($objectives as $index => $objective)
            @include('admin.components.userPartials.objetiveBlock', ['index' => $index, 'objective' => $objective])
        @endforeach
    </div>

    <div class="text-end mt-3">
        <button type="button" class="btn btn-success btn-sm" id="addAObjectiveBtn">
            <i class="fa-solid fa-plus"></i> 
        </button>
        <button type="submit" class="btn btn-primary btn-sm" id="submitObjectivesBtn">
            <i class="fa-solid fa-floppy-disk"></i>
        </button>
        <a href="{{ route('users') }}" class="btn btn-danger btn-sm">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
    </div>
    <input type="hidden" name="deleted[]" id="deletedObjectives">
    <input type="hidden" name="news[]" id="newObjectives">
</form>
