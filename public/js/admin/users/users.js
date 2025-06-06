function addUser() {
    window.location.href = '/admin/users/addUser';
}

function editUser(id) {
    window.location.href = `/admin/users/editUser/${id}`;
}

function viewUser(id) {
    window.location.href = `/admin/users/previewUser/${id}`;
}

function sendDeleteForm(id) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '/admin/users/deleteUser';

    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = token;
    form.appendChild(csrfInput);

    const idInput = document.createElement('input');
    idInput.type = 'hidden';
    idInput.name = 'id';
    idInput.value = id;
    form.appendChild(idInput);

    document.body.appendChild(form);
    form.submit();
}

function deleteUser(id) {
    swal({
        title: "¿Estás seguro?",
        text: "Estás a punto de eliminar este Usuario.",
        icon: "warning",
        buttons: {
            cancel: {
                text: "Cancelar",
                value: null,
                visible: true,
                className: "btn-cancel",
                closeModal: true
            },
            confirm: {
                text: "Sí, continuar",
                value: true,
                visible: true,
                className: "btn-confirm",
                closeModal: true
            }
        }
    }).then(function (firstConfirmed) {
        if (firstConfirmed) {
            swal({
                title: "¡Confirmación final!",
                text: "¿Realmente deseas eliminar este Usuario? Esta acción no se puede deshacer.",
                icon: "warning",
                buttons: {
                    cancel: {
                        text: "No, cancelar",
                        value: null,
                        visible: true,
                        className: "btn-cancel",
                        closeModal: true
                    },
                    confirm: {
                        text: "Sí, eliminar",
                        value: true,
                        visible: true,
                        className: "btn-danger",
                        closeModal: true
                    }
                }
            }).then(secondConfirmed => {
                if (secondConfirmed) {
                    sendDeleteForm(id);
                }
            });
        }
    });
}
