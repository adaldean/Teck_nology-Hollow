<table class="tabla-usuarios">
    <thead>
        <tr>
            <th>ID</th>
            <th>NOMBRE</th>
            <th>EMAIL</th>
            <th>CONTRASEÑA</th>
            <th>ROL</th>
            <th>ACCIONES</th>
        </tr>
    </thead>
    <tbody>
        @foreach($usuarios as $usuario)
            <tr>
                <td>{{ $usuario->id_usuario }}</td>
                <td>{{ $usuario->nombre }}</td>
                <td>{{ $usuario->email }}</td>
                <td>{{ substr($usuario->contrasena, 0, 20) }}...</td>
                <td>{{ $usuario->rol->nombre ?? 'Sin rol' }}</td>
                <td>
                    <button class="boton-editar" 
                            data-id="{{ $usuario->id_usuario }}" 
                            data-nombre="{{ $usuario->nombre }}" 
                            data-email="{{ $usuario->email }}" 
                            type="button">Editar</button>
                    <form action="{{ route('usuarios.destroy', $usuario->id_usuario) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="boton-eliminar">Eliminar</button>
                    </form>
                </td>
            </tr>
        @endforeach

        @empty($usuarios)
            <tr>
                <td colspan="6" style="text-align:center;">No hay usuarios registrados.</td>
            </tr>
        @endempty
    </tbody>
</table>