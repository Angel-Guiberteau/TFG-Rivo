<div class="card h-100">
    <div class="card-header">
        <i class="fas fa-user me-2"></i>Información del Usuario
    </div>
    <div class="card-body card-user-info">
        <div class="row">
            <div class="col-md-6">
                <p><strong>ID:</strong> {{ $user->id }}</p>
                <p><strong>Nombre:</strong> {{ $user->name }}</p>
                <p><strong>Apellido:</strong> {{ $user->last_name }}</p>
                <p><strong>Usuario:</strong> {{ $user->username }}</p>
                <p><strong>Correo:</strong> {{ $user->email }}</p>
                <p><strong>Google ID:</strong> {{ $user->google_id ?? 'No vinculado' }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Fecha Nacimiento:</strong> {{ $user->birth_date }}</p>
                <p><strong>Rol:</strong> {{ $user->rol_id }}</p>
                <p>
                    <strong>Estado:</strong>
                    <span class="badge-status bg-{{ $user->enabled ? 'success' : 'danger' }}">
                        {{ $user->enabled ? 'Activo' : 'Inactivo' }}
                    </span>
                </p>
                <p>
                    <strong>Usuario Nuevo:</strong>
                    <span class="badge-status bg-{{ $user->isNewUser ? 'info' : 'secondary' }}">
                        {{ $user->isNewUser ? 'Sí' : 'No' }}
                    </span>
                </p>
                <p><strong>Creado:</strong> {{ $user->created_at->format('d/m/Y H:i') }}</p>
                <p><strong>Actualizado:</strong> {{ $user->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>