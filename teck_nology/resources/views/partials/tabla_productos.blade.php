<table class="tabla-productos">
    <thead>
        <tr>
            <th class="columna-checkbox"><input type="checkbox" class="checkbox-todos"></th>
            <th class="columna-id">ID</th>
            <th class="columna-nombre">NOMBRE</th>
            <th class="columna-descripcion">DESCRIPCIÓN</th>
            <th class="columna-precio">PRECIO</th>
            <th class="columna-stock">STOCK</th>
            <th class="columna-categoria">CATEGORIA</th>
            <th class="columna-proveedor">PROVEEDOR</th>
            <th class="columna-acciones">ACCIONES</th>
        </tr>
    </thead>
    <tbody>
        @forelse($productos as $producto)
        <tr class="fila-producto">
            <td class="columna-checkbox"><input type="checkbox" name="producto_ids[]" value="{{ $producto->id_producto }}"></td>
            <td class="columna-id">{{ $producto->id_producto }}</td>
            <td class="columna-nombre">{{ $producto->nombre }}</td>
            <td class="columna-descripcion">{{ Str::limit($producto->descripcion, 80) }}</td>
            <td class="columna-precio">${{ number_format($producto->precio, 2) }}</td>
            <td class="columna-stock">{{ $producto->stock }}</td>
            <td class="columna-categoria">{{ $producto->categoria->nombre ?? 'Sin categoría' }}</td>
            <td class="columna-proveedor">{{ $producto->proveedor->nombre ?? 'Sin proveedor' }}</td>
            <td class="columna-acciones">
                <a href="{{ route('inventario.edit', $producto->id_producto) }}" class="boton-editar btn-admin">Editar</a>

                <form action="{{ route('inventario.destroy', $producto->id_producto) }}" method="POST" style="display:inline-block; margin:0 0 0 8px;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="boton-eliminar btn-admin" onclick="return confirm('¿Seguro que deseas eliminar este producto?')">Eliminar</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="9" style="text-align:center;">No hay productos encontrados.</td>
        </tr>
        @endforelse
    </tbody>
</table>
