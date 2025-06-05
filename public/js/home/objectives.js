document.addEventListener('DOMContentLoaded', () => {

document.querySelectorAll('.btn-objective.edit').forEach(button => {
    button.addEventListener('click', async () => {
        const id = button.dataset.id;
        try {
            const res = await fetch(`/api/objective/getObjective/${id}`);
            const objective = await res.json();
            console.log(objective);


            document.querySelector('input[name="objective_id"]').value = objective.id;
            document.querySelector('input[name="name"]').value = objective.name;
            document.querySelector('input[name="target_amount"]').value = objective.target_amount;

            document.querySelector('.objective-form h2').textContent = 'Editar objetivo';
            document.querySelector('.objective-form button[type="submit"]').textContent = 'Actualizar objetivo';

            const section = document.getElementById('objectiveAdd-section');
            section.style.display = 'block';
            section.classList.add('show');

            section.scrollIntoView({ behavior: 'smooth' });

        } catch (error) {
            console.error('Error cargando objetivo:', error);
            swal('Error', 'No se pudo cargar el objetivo para editar.', 'error');
        }
    });
});



    document.querySelectorAll('.btn-objective.delete').forEach(button => {
        button.onclick = () => {
            swal({
                title: "¿Eliminar objetivo?",
                text: "Esta acción no se puede deshacer.",
                icon: "warning",
                buttons: ["Cancelar", "Sí, eliminar"],
                dangerMode: true
            }).then(async (willDelete) => {
                if (!willDelete) return;

                const id = button.dataset.id;
                const container = button.closest('.objective-container');
                if (!id) {
                    console.error("ID de objetivo no encontrado.");
                    return swal("Error al obtener el objetivo.", { icon: "error" });
                }

                try {
                    const data = await fetch(`/api/objective/deleteObjective/${id}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Content-Type': 'application/json'
                        }
                    });
                    const response = await data.json();

                    if (!response.success) throw new Error('Error al eliminar');

                    document.querySelectorAll(`.objective-item[data-id="${id}"]`).forEach(el => {
                        el.classList.add('fade-out');
                        setTimeout(() => el.remove(), 300);
                    });

                    swal("Objetivo eliminado correctamente", {
                        icon: "success",
                        timer: 2000,
                        buttons: false
                    });

                    const visibleSection = document.querySelector('article.show');
                    if (visibleSection?.id?.includes('section')) {
                        const sectionType = visibleSection.id.replace('-section', '');
                        if (typeof refreshHistory === 'function') {
                            refreshHistory(sectionType);
                        }
                    }

                } catch (error) {
                    console.error(error);
                    swal("Error al eliminar el objetivo", {
                        icon: "error"
                    });
                }
            });
        };
    });

});
