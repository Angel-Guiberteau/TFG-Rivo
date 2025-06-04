<article class="row m-0 gx-0 gx-lg-4 px-3 px-lg-5 py-3 py-lg-5 text-black objective-article" id="objectiveAdd-section" style="display: none;">
    @if (isset($objectives))
        <h2 class="mt-4 fw-bold">Objetivos Actuales</h2>
        @foreach ($objectives as $objective)
            @include('templates.home.objective')
        @endforeach

        <hr class=" mt-4 separator">
    @endif
    <form class="col-12 col-lg-10 mx-auto mt-4" method="POST" action="{{ route('addObjective') }}">
        @csrf
        <input type="hidden" name="operation_id" id="operation_id"> 
        <div class="d-flex flex-row justify-content-between align-items-center">
            <h2 class="fw-bold fs-3">Añadir objetivo</h2>
        </div>

        <hr class="separator">

        <div class="row justify-content-between align-items-center">
            <div class="col-12 mb-3">
                <p for="subject" class="fw-bold mb-2 fs-4">Nombre del objetivo</p>
                <input type="text" id="objectiveName" name="name" class="form-control mb-3 custom-input" placeholder="Nombre del objetivo" required>
            </div>
            <div class="col-12 mb-3">
                <p for="subject" class="fw-bold mb-2 fs-4">Dinero objetivo</p>
                <input type="number" id="" name="target_amount" class="form-control mb-3 custom-input" placeholder="Dinero objetivo" required>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-primary w-100 py-2 mt-3 fw-semibold fs-5 custom-gradient-btn">
                Añadir objetivo
            </button>
        </div>
    </form>
</article>