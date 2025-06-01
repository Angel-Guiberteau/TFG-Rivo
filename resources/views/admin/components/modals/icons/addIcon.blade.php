<div id="addIcon" class="modal fade">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-custom text-white">
                <h5 class="modal-title">Añadir icono</h5>
                <button type="button" class="btn-close" style="filter: invert(1);" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form id="form-addIcon" class="row g-3 needs-validation" action=" {{ route('addIcon') }} " method="post" accept-charset="UTF-8" enctype="multipart/form-data" novalidate>
                    @csrf
                    <label class="icons">
                        <span id="iconPreviewAdd"></span>
                    </label>
                    <div class="col-12">
                        <label class="form-label" for="name">Icono <span class="modal_required">*</span></label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Ej: fas fa-user" required/>
                        <div class="valid-feedback">¡Parece correcto!</div>
                        <div class="invalid-feedback">Por favor, introduce una icono correcta.</div>
                    </div>
                    <div class="col-12 d-flex flex-column align-items-end"> 
                        <button type="submit" class="btn btn-primary btn-sm" id="buttonSubmit"> Añadir </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
