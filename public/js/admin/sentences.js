document.addEventListener('DOMContentLoaded', function () {
    const editButtons = document.querySelectorAll('button[data-bs-target="#editSentence"]');

    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            const sentence = this.getAttribute('data-name');

            document.getElementById('edit_id').value = id;
            document.getElementById('idEdit').value = id;
            document.getElementById('nameEdit').value = sentence;
        });
    });
});

function deleteSentence(id) {
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
                    fetch('/admin/sentences/deleteSentence', {
                        method: "POST",
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // si usas Laravel con CSRF
                        },
                        body: JSON.stringify({ id: id })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error("Respuesta no válida del servidor");
                        }
                        return response.json();
                    })
                    .then(data => {
                        const swalBox = document.createElement('div');
                        swalBox.textContent = data.success || data.error || "Respuesta inesperada";
                        swalBox.style.position = 'fixed';
                        swalBox.style.bottom = '1rem';
                        swalBox.style.right = '1rem';
                        swalBox.style.minWidth = '300px';
                        swalBox.style.maxWidth = '90%';
                        swalBox.style.textAlign = 'center';
                        swalBox.style.padding = '0.8rem 1.5rem';
                        swalBox.style.borderRadius = '8px';
                        swalBox.style.fontSize = '0.9rem';
                        swalBox.style.zIndex = 9999;
                        swalBox.style.boxShadow = '0 4px 10px rgba(0,0,0,0.2)';
                        
                        if (data.success) {
                            swalBox.style.backgroundColor = '#dff0d8'; 
                            swalBox.style.color = '#3c763d';
                            swalBox.style.border = '1px solid #d6e9c6';
                        } else {
                            swalBox.style.backgroundColor = '#f2dede';
                            swalBox.style.color = '#a94442';
                            swalBox.style.border = '1px solid #ebccd1';
                        }

                        document.body.appendChild(swalBox);
                        setTimeout(() => location.reload(), 1200);
                    })
                    .catch(error => {
                        console.error("Error al procesar la solicitud:", error);
                        const swalBox = document.createElement('div');
                        swalBox.textContent = "Hubo un problema en el servidor.";
                        swalBox.style.position = 'fixed';
                        swalBox.style.bottom = '1rem';
                        swalBox.style.right = '1rem';
                        swalBox.style.minWidth = '300px';
                        swalBox.style.maxWidth = '90%';
                        swalBox.style.textAlign = 'center';
                        swalBox.style.padding = '0.8rem 1.5rem';
                        swalBox.style.backgroundColor = '#f2dede'; 
                        swalBox.style.color = '#a94442';
                        swalBox.style.border = '1px solid #ebccd1';
                        swalBox.style.borderRadius = '8px';
                        swalBox.style.fontSize = '0.9rem';
                        swalBox.style.zIndex = 9999;
                        swalBox.style.boxShadow = '0 4px 10px rgba(0,0,0,0.2)';
                        document.body.appendChild(swalBox);
                        setTimeout(() => location.reload(), 2000);
                    });
                }
            });
        }
    });
}

function preViewSentence(text) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '/admin/sentences/preViewSentence';

    const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    form.innerHTML = `
        <input type="hidden" name="_token" value="${csrf}">
        <input type="hidden" name="text" value="${text}">
    `;

    document.body.appendChild(form);
    form.submit();
}