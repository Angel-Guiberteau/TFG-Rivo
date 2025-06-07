<div class="card h-100">
    <div class="card-header bg-secondary">
        <i class="fas fa-layer-group me-2"></i>Categorías Personales
    </div>
    <div class="card-body">
        @forelse($personalCategories as $category)
            <div class="category-item">
                <div class="d-flex align-items-center">
                    <span class="category-icon">{!! $category['icon'] !!}</span>
                    <span class="fw-semibold">{{ $category['name'] }}</span>
                </div>
                @if(!empty($category['movement_type_ids']))
                    <div class="ms-4 mt-1">
                        <small class="text-muted">Tipos de movimiento:</small>
                        <ul class="mb-0 ps-3">
                            @foreach($category['movement_type_ids'] as $typeId)
                                @foreach($movementTypes as $type)
                                    @if($type['id'] == $typeId)
                                        <li>{{ $type['name'] }}</li>
                                    @endif
                                @endforeach
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        @empty
            <p class="text-muted">No hay categorías personales asignadas.</p>
        @endforelse
    </div>
</div>