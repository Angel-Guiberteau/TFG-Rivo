document.addEventListener('DOMContentLoaded', function() {
    const successMessage = sessionStorage.getItem('success');
    if (successMessage) {
        swal(successMessage, {
            icon: "success",
            timer: 2000,
            buttons: false
        });
        sessionStorage.removeItem('success');
    }

    document.querySelectorAll('.btn-delete-category').forEach(button => {
        button.addEventListener('click', async () => {
            const id = button.dataset.id;

            const confirm = await swal({
                title: "¿Eliminar categoría?",
                text: "No podrás recuperarla.",
                icon: "warning",
                buttons: ["Cancelar", "Eliminar"],
                dangerMode: true,
            });

            if (!confirm) return;

            try {
                const data = await fetch(`/api/category/delete/${id}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    }
                });
                const response = await data.json();
                console.log(response);

                if (!response.success) throw new Error('Error al eliminar');

                if(response.success){
                    sessionStorage.setItem('success', response.success);
                    location.reload();
                }
            } catch (error) {
                swal({
                    icon: "error",
                    title: "Error al eliminar",
                    text: "Error al eliminar la categoría.\nPuedes tener alguna operación con esta categoría que no permite borrarla."
                });



            }
        });
    });

    document.querySelectorAll('.btn-edit-category').forEach(button => {
        button.addEventListener('click', async () => {
            const id = button.dataset.id;

            try {
                const res = await fetch(`/api/category/${id}`);
                const category = await res.json();

                document.querySelector('input[name="operation_id"]').value = category.id;
                document.querySelector('input[name="name"]').value = category.category_name;
                document.querySelector('input[name="icon"]').value = category.icon_id;

                document.querySelectorAll('.operation-types input[type="checkbox"]').forEach(chk => {
                    chk.checked = category.movement_type_names.includes(chk.value);
                });

                document.querySelectorAll('.icon-option').forEach(icon => {
                    icon.classList.toggle('selected', icon.dataset.icon == category.icon_html);
                });

                document.querySelector('#submitCategories').textContent = 'Actualizar categoría';

                document.getElementById('categoryAdd-section').scrollIntoView({ behavior: 'smooth' });

            } catch (error) {
                console.error('Error cargando categoría', error);
            }
        });
    });

});
