@foreach($usuarios as $user)
<tr>
    {{-- Ahora usamos los nombres exactos definidos en el Modelo/Migración --}}
    <td class="ps-4 fw-bold text-muted">{{ $user->usuario_id }}</td>
    <td class="fw-medium text-dark">{{ $user->usuario_nombre }}</td>
    <td class="text-dark">{{ $user->usuario_apellido }}</td>
    <td>
        <span class="text-primary fw-bold">@</span>{{ $user->usuario_usuario }}
    </td>
    <td>
        {{-- El rol ahora viene directo del modelo --}}
        @php
            $rolLower = strtolower($user->rol);
            $badgeColor = match($rolLower) {
                'administrador' => 'background-color: #dc3545; color: white;',
                'inventario'    => 'background-color: #ffc107; color: #000;',
                'ventas'        => 'background-color: #198754; color: white;',
                default         => 'background-color: #6c757d; color: white;'
            };
        @endphp
        <span class="badge shadow-sm px-3 py-2" style="{{ $badgeColor }} border-radius: 6px; font-size: 0.75rem;">
            {{ strtoupper($user->rol) }}
        </span>
    </td>
    <td class="text-center">
        @if($user->usuario_id == 1 || $rolLower == 'administrador')
            <span class="badge bg-light text-secondary border px-3 py-2">
                <i class="fas fa-lock me-1"></i> Usuario actual
            </span>
        @else
            <div class="d-flex justify-content-center gap-2">
                <a href="{{ route('usuarios.edit', $user->usuario_id) }}" class="btn btn-sm btn-light border shadow-sm">
                    <i class="fas fa-edit text-dark"></i>
                </a>
                <form action="{{ route('usuarios.destroy', $user->usuario_id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger shadow-sm px-3">
                        <i class="fas fa-trash-alt me-1"></i> Eliminar
                    </button>
                </form>
            </div>
        @endif
    </td>
</tr>
@endforeach