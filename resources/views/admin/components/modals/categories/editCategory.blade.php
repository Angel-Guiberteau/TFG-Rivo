<div id="editCategory" class="modal fade">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-custom text-white">
                <h5 class="modal-title">Editar Categoria</h5>
                <button type="button" class="btn-close" style="filter: invert(1);" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form id="form-editCategory" class="row g-3 needs-validation" action=" {{ route('editCategory') }} " method="POST" novalidate>
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_id" name="id">
                    <div class="col-12">
                        <label class="form-label" for="name">Categoria <span class="modal_required">*</span></label>
                        <input type="text" id="nameEdit" name="name" class="form-control" required maxlength="75">
                        <div class="valid-feedback">¡Parece correcto!</div>
                        <div class="invalid-feedback">Por favor, introduce una Categoria correcta.</div>
                    </div>
                    <div class="col-12 d-flex flex-column align-items-end">
                        <button type="submit" class="btn btn-primary btn-sm" id="buttonSubmitEdit"> Editar </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
