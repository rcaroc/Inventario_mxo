@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="fas fa-users me-2 text-primary"></i> Lista de Usuarios
                    </h5>
                    <a href="{{ route('usuarios.create') }}" class="btn btn-primary btn-sm shadow-sm">
                        <i class="fas fa-user-plus me-1"></i> Nuevo Usuario
                    </a>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">ID</th>
                                    <th>Usuario (User)</th>
                                    <th>Nombre Completo</th>
                                    <th>Rol</th>
                                    <th class="text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($usuarios as $user)
                                    <tr>
                                        <td class="ps-4 fw-bold text-muted">{{ $user->usuario_id }}</td>
                                        <td>
                                            <span class="badge bg-light text-dark border">
                                                <i class="fas fa-at me-1"></i>{{ $user->usuario_user }}
                                            </span>
                                        </td>
                                        <td>{{ $user->usuario_nombre }}</td>
                                        <td>
                                            @if($user->usuario_rol == 'Administrador')
                                                <span class="badge bg-danger">
                                                    <i class="fas fa-shield-alt me-1"></i>{{ $user->usuario_rol }}
                                                </span>
                                            @else
                                                <span class="badge bg-info text-dark">
                                                    <i class="fas fa-user me-1"></i>{{ $user->usuario_rol }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group shadow-sm">
                                                <button class="btn btn-sm btn-outline-secondary" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger" title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">
                                            <i class="fas fa-info-circle fa-2x mb-3"></i><br>
                                            No se encontraron usuarios registrados en la base de datos.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="card-footer bg-white text-muted small py-3">
                    Mostrando un total de {{ count($usuarios) }} usuarios registrados.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection