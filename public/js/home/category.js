document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('resetCategoryButton').addEventListener('click', () => {
        document.querySelector('input[name="id"]').value = '';
        document.querySelector('input[name="name"]').value = '';
        document.querySelector('input[name="icon"]').value = '';

        document.querySelectorAll('.icon-option').forEach(icon => icon.classList.remove('selected'));

        document.querySelectorAll('.operation-types input[type="checkbox"]').forEach(chk => chk.checked = false);

        document.querySelector('#categoryName').value = '';

        document.getElementById('submitCategories').textContent = 'Añadir categoría';

        document.getElementById('categoryAdd-section').scrollIntoView({ behavior: 'smooth' });

        document.getElementById('resetCategoryButton').classList.add('d-none');
    });


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
                const response = await fetch(`/api/category/getCategory/${id}`);
                const category = await response.json();
                console.log(category);

                document.querySelector('input[name="id"]').value = category.id;

                document.querySelector('#categoryName').value = category.name;
                document.querySelector('input[name="icon"]').value = category.icon_id;

                const typeIds = category.movement_types.map(t => t.id);
                document.querySelectorAll('.operation-types input[type="checkbox"]').forEach(chk => {
                    const map = { income: 1, expense: 2, save: 3 };
                    chk.checked = typeIds.includes(map[chk.value]);
                });

                document.querySelectorAll('.icon-option').forEach(icon => {
                    icon.classList.toggle('selected', icon.dataset.id == category.icon_id);
                });

                document.getElementById('resetCategoryButton').classList.remove('d-none');

                document.querySelector('#submitCategories').textContent = 'Actualizar categoría';

                document.getElementById('categoryAdd-section').scrollIntoView({ behavior: 'smooth' });

            } catch (error) {
                console.error('Error cargando categoría', error);
                swal("Error al cargar la categoría", { icon: "error" });
            }


        });
    });


});
