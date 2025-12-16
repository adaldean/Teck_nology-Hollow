<table class="tabla-usuarios">
    <thead>
        <tr>
            <th>ID</th>
            <th>NOMBRE</th>
            <th>EMAIL</th>
            <th>TELEFONO</th>
            <th>DIRECCION</th>
            <th>ACCIONES</th>
        </tr>
    </thead>
    <tbody>
        @forelse($clientes as $cliente)
        <tr>
            <td class="columna-id">{{ $cliente->id_cliente }}</td>
            <td>{{ $cliente->nombre }}</td>
            <td>{{ $cliente->email }}</td>
            <td>{{ $cliente->telefono }}</td>
            <td>{{ $cliente->direccion }}</td>
            <td>
                <a href="{{ route('clientes.edit', $cliente->id_cliente) }}" class="boton-editar btn-admin">Editar</a>
                <form action="{{ route('clientes.destroy', $cliente->id_cliente) }}" method="POST" style="display:inline-block; margin:0 0 0 8px;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="boton-eliminar btn-admin" onclick="return confirm('¿Seguro que deseas eliminar este cliente?')">Eliminar</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" style="text-align:center;">No hay clientes registrados.</td>
        </tr>
        @endforelse
    </tbody>
</table>