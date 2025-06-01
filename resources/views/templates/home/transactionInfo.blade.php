<div id="transactionDetail" class="transaction-panel-light hidden">
    <div class="transaction-light-content">

        <div class="transaction-light-header">
            <div class="icon-circle-light"><i class="fas fa-money-bill-wave"></i></div>
            <div>
                <p class="badge-light income">Ingreso</p>
                <h2 class="tx-title">Título</h2>
            </div>
        </div>

        <div class="tx-section full" id="tx-description">
            <p class="tx-label">Descripción</p>
            <p class="tx-value">...</p>
        </div>

        <div class="tx-grid">
            <div class="tx-section" id="tx-category">
                <p class="tx-label">Categoría</p>
                <p class="tx-value">...</p>
            </div>
            <div class="tx-section" id="tx-amount">
                <p class="tx-label">Cantidad</p>
                <p class="tx-value">...</p>
            </div>
        </div>

        <div class="tx-section full" id="tx-date">
            <p class="tx-label">Fecha de operación</p>
            <p class="tx-value">...</p>
        </div>

        <div class="tx-section full" id="tx-recurrente">
            <p class="tx-label">Recurrente</p>
            <p class="tx-value">Sí</p>
            <div class="tx-grid">
                <div class="tx-sub">
                    <p class="tx-label">Inicio</p>
                    <p class="tx-value">...</p>
                </div>
                <div class="tx-sub">
                    <p class="tx-label">Expira</p>
                    <p class="tx-value">...</p>
                </div>
                <div class="tx-sub">
                    <p class="tx-label">Periodo</p>
                    <p class="tx-value">...</p>
                </div>
            </div>
        </div>

        <div class="tx-section full">
            <p class="tx-label mb-1">Acciones</p>
            <div class="tx-actions horizontal">
                <button class="btn-full edit">
                    <i class="fas fa-pen"></i>
                    Editar
                </button>
                <button class="btn-full delete">
                    <i class="fas fa-trash"></i>
                    Eliminar
                </button>
            </div>
        </div>

        <div class="tx-close mt-3">
            <button class="btn-close-link" onclick="closePanel()">
                <i class="fas fa-times"></i> Cerrar
            </button>
        </div>
    </div>
</div>

<script>
    const panel = document.getElementById('transactionDetail');

    function openPanel() {
        panel.classList.add('show');
        panel.classList.remove('hidden');
        document.body.classList.add('no-scroll', 'blur-active');
    }

    function closePanel() {
        panel.classList.remove('show');
        document.body.classList.remove('no-scroll', 'blur-active');
        setTimeout(() => {
            panel.classList.add('hidden');
        }, 400);
    }

    document.addEventListener('click', function (event) {
        if (
            panel.classList.contains('show') &&
            !panel.contains(event.target) &&
            !event.target.closest('.movement-row')
        ) {
            closePanel();
        }
    });

    document.querySelectorAll('.movement-row').forEach(row => {
        row.addEventListener('click', async () => {
            const id = row.dataset.id;
            try {
                const res = await fetch(`/transaction/${id}`);
                const data = await res.json();
                console.log(data);
                
                const iconContainer = document.querySelector('.icon-circle-light');
                iconContainer.innerHTML = '';
                iconContainer.innerHTML = data.icon_html;


                // Título y badge
                document.querySelector('.tx-title').textContent = data.subject;
                const badge = document.querySelector('.badge-light');
                badge.textContent = getBadgeText(data.movement_type_id);
                badge.className = 'badge-light ' + getBadgeClass(data.movement_type_id);

                // Descripción
                document.querySelector('#tx-description .tx-value').textContent = data.description;

                // Categoría
                document.querySelector('#tx-category .tx-value').textContent = data.category_name || '—';

                // Cantidad
                const amountEl = document.querySelector('#tx-amount .tx-value');
                amountEl.textContent = `${data.amount > 0 ? '+' : ''}${parseFloat(data.amount).toFixed(2)}€`;
                amountEl.className = 'tx-value ' + (data.amount > 0 ? 'positive' : '');

                // Fecha operación
                document.querySelector('#tx-date .tx-value').textContent = formatDate(data.action_date);

                // Recurrente
                const recurrenteEl = document.getElementById('tx-recurrente');
                if (data.is_recurrent) {
                    recurrenteEl.style.display = 'block';
                    recurrenteEl.querySelector('.tx-value').textContent = 'Sí';
                    const subs = recurrenteEl.querySelectorAll('.tx-sub .tx-value');
                    subs[0].textContent = formatDate(data.start_date);
                    subs[1].textContent = formatDate(data.expiration_date);
                    subs[2].textContent = getRecurrenceText(data.recurrence);
                } else {
                    recurrenteEl.style.display = 'none';
                }

                openPanel();
            } catch (error) {
                console.error('Error al cargar transacción:', error);
            }
        });
    });

    function getBadgeText(typeId) {
        switch (typeId) {
            case 1: return 'Ingreso';
            case 2: return 'Gasto';
            case 3: return 'Ahorro';
            default: return '';
        }
    }

    function getBadgeClass(typeId) {
        switch (typeId) {
            case 1: return 'income';
            case 2: return 'expense';
            case 3: return 'save';
            default: return '';
        }
    }

    function getRecurrenceText(code) {
        switch (code) {
            case 'd': return 'Diario';
            case 'w': return 'Semanal';
            case 'm': return 'Mensual';
            default: return 'Otro';
        }
    }

    function formatDate(dateStr) {
        if(dateStr === null){
            return 'Sin fecha';
        }
        const date = new Date(dateStr);
        const day = date.getDate();
        const month = date.toLocaleString('es-ES', { month: 'long' });
        const year = date.getFullYear();
        const hours = date.getHours().toString().padStart(2, '0');
        const minutes = date.getMinutes().toString().padStart(2, '0');

        return `${day} ${month} ${year} - ${hours}:${minutes}`;
    }


</script>