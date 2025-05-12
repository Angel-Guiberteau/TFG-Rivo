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