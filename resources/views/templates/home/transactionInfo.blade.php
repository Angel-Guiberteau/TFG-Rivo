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
