@forelse($usuarios as $user)
<tr class="border-bottom">
    <td class="ps-4 fw-bold text-dark">{{ $user->name }}</td>
    <td class="text-muted">{{ $user->email }}</td>
    <td>
        <span class="badge bg-light text-dark border px-3">
            {{ $user->rol ?? 'Usuario' }}
        </span>
    </td>
    <td class="text-center">
        <div class="d-flex justify-content-center gap-2">
            
            {{-- EL CAMBIO ESTÁ AQUÍ: Nos aseguramos de pasar $user->id --}}
            <a href="{{ route('usuarios.edit', $user->id) }}" class="btn-editar-custom">
                Editar
            </a>
            
            <form id="form-eliminar-{{ $user->id }}" action="{{ route('usuarios.destroy', $user->id) }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>

            <button type="button" class="btn-eliminar-custom" onclick="confirmarEliminar({{ $user->id }})">
                Eliminar
            </button>

        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="4" class="text-center py-5 text-muted">No hay usuarios registrados.</td>
</tr>
@endforelse