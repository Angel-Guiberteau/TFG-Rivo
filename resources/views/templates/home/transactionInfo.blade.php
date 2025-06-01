<div id="transactionDetail" class="transaction-panel hidden">
    <div class="panel-content">
        <div class="panel-header">
            <div class="icon-container">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div>
                <p class="badge badge-income">Ingreso</p>
                <h2 class="transaction-title">Salario</h2>
            </div>
        </div>

        <div class="panel-body">
            <div class="detail-row">
                <span>Monto:</span>
                <strong class="positive">+123,00€</strong>
            </div>
            <div class="detail-row">
                <span>Fecha:</span>
                <span>1 junio 2025</span>
            </div>
            <div class="detail-row">
                <span>Recurrencia:</span>
                <span>No recurrente</span>
            </div>
            <div class="detail-row">
                <span>Notas:</span>
                <span>Pago mensual</span>
            </div>
        </div>

        <div class="panel-actions">
            <button class="btn btn-edit">Editar</button>
            <button class="btn btn-delete">Eliminar</button>
            <button class="btn btn-close" onclick="closePanel()">Cerrar</button>
        </div>
    </div>
</div>
<script>
    function openPanel() {
        document.getElementById('transactionDetail').classList.add('show');
        document.getElementById('transactionDetail').classList.remove('hidden');
    }

    function closePanel() {
        document.getElementById('transactionDetail').classList.remove('show');
        setTimeout(() => {
            document.getElementById('transactionDetail').classList.add('hidden');
        }, 400);
    }
    document.querySelectorAll('.movement-row').forEach(row => {
        row.addEventListener('click', openPanel);
    });
</script>
