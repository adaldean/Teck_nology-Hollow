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
        @forelse($usuarios as $usuario)
            <tr>
                <td>{{ $usuario->id_usuario }}</td>
                <td>{{ $usuario->nombre }}</td>
                <td>{{ $usuario->email }}</td>
                <td>{{ $usuario->contrasena }}</td>
                <td>{{ $usuario->rol->nombre ?? 'Sin rol' }}</td>
                <td>
                    <a href="{{ url('usuarios/'.$usuario->id_usuario.'/editar') }}" class="boton-editar">Editar</a>
                    <form action="{{ url('usuarios/'.$usuario->id_usuario.'/eliminar') }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="boton-eliminar">Eliminar</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" style="text-align:center;">No hay usuarios registrados.</td>
            </tr>
        @endforelse
    </tbody>
</table>
