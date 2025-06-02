<div id="editIcon" class="modal fade">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-custom text-white">
                <h5 class="modal-title">Editar icono</h5>
                <button type="button" class="btn-close" style="filter: invert(1);" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form id="form-editIcon" class="row g-3 needs-validation" action=" {{ route('editIcon') }} " method="POST" novalidate>
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_id" name="id">
                    <div class="col-12">
                        <label class="form-label" for="name">Icono <span class="modal_required">*</span></label>
                        <div class="d-flex align-items-start gap-2">
                            <label class="icons">
                                <span id="iconPreviewEdit"></span>
                            </label>
                            <div class="input-group w-100">
                                <span class="input-group-text">&lt;i class="</span>
                                <input type="text" id="nameEdit" name="name" class="form-control" required>
                                <span class="input-group-text">"&gt;&lt;/i&gt;</span>
                                <div class="valid-feedback text-center">¡Parece correcto!</div>
                                <div class="invalid-feedback text-center">Por favor, introduce una icono correcta.</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 d-flex flex-column align-items-end">
                        <button type="submit" class="btn btn-primary btn-sm" id="buttonSubmitEdit"> Editar </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
