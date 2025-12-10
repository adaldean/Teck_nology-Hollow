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
            <td>{{ $cliente->id_cliente }}</td>
            <td>{{ $cliente->nombre }}</td>
            <td>{{ $cliente->email }}</td>
            <td>{{ $cliente->telefono }}</td>
            <td>{{ $cliente->direccion }}</td>
            <td>
                <a href="{{ url('clientes/'.$cliente->id_cliente.'/editar') }}" class="boton-editar">Editar</a>
                <form action="{{ url('clientes/'.$cliente->id_cliente.'/eliminar') }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="boton-eliminar">Eliminar</button>
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