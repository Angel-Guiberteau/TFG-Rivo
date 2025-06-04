function addUser() {
    window.location.href = '/admin/users/addUser';
}

function editUser(id) {
    window.location.href = `/admin/users/editUser/${id}`;
}

function viewUser(id) {
    window.location.href = `/admin/users/previewUser/${id}`;
}

function deleteUser(id) {
    swal({
        title: "¿Estás seguro?",
        text: "Estás a punto de eliminar esta frase.",
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
                text: "¿Realmente deseas eliminar esta frase? Esta acción no se puede deshacer.",
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
            }).then(function (secondConfirmed) {
                if (secondConfirmed) {
                    fetch('/admin/users/deleteUser', {
                        method: "POST",
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ id: id })
                    })
                    .then(response => {
                        if (response.redirected) {
                            window.location.href = response.url;
                        } else {
                            location.reload();
                        }
                    })
                    .catch(error => {
                        console.error("Error al procesar la solicitud:", error);
                        location.reload();
                    });
                }
            });
        }
    });
}
