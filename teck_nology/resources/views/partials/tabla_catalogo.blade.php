<div class="contenido-principal">
    <section class="area-productos">
    <div class="opciones-clasificacion">
      <a class="chip-categoria activo" data-categoria="todos">Todos</a>
      <a class="chip-categoria" data-categoria="computadoras">Computadoras</a>
      <a class="chip-categoria" data-categoria="moviles">Moviles</a>
      <a class="chip-categoria" data-categoria="accesorios">Accesorios</a>
      <a class="chip-categoria" data-categoria="consolas">Consolas</a>         
    </div>
          
          <div class="opciones-ordenar">          
          <button class="boton-ordenar activo" data-orden="productos">Productos</button>
          <button class="boton-ordenar" data-orden="asc">Precio ascendente</button>
          <button class="boton-ordenar" data-orden="desc">Precio descendiente</button>
          <button class="boton-ordenar" data-orden="ofretas">Ofertas </button>
          </div>
          
          <div class="productos-cuadricula">
            @foreach($productos as $producto)
            <div class="producto-tarjeta">
        <div class="producto-imagen">
          @php
            $img = $producto->imagen ?? null;
            // Default placeholder if no image
            $default = asset('imagenes/19e743dc-8b04-43b4-ad4b-da5ba6b4e109.png');
            $src = $default;
            if ($img) {
              // If image was stored via the storage disk (e.g. 'productos/filename'), serve from /storage
              if (\Illuminate\Support\Str::startsWith($img, 'productos/') || \Illuminate\Support\Str::startsWith($img, 'storage/')) {
                // ensure we don't duplicate 'storage/' prefix
                $clean = preg_replace('/^storage\//', '', $img);
                $src = asset('storage/' . $clean);
              } else {
                // Otherwise assume the file is in public/imagenes
                $src = asset('imagenes/' . $img);
              }
            }
          @endphp
          <img src="{{ $src }}" alt="{{ $producto->nombre }}">
          </div>
              <div class="producto-info">
                <p class="producto-nombre">{{ $producto->nombre }}</p>
                <p class="producto-precio">${{ $producto->precio }}</p>
        <button class="agregar-carrito" 
          data-id="{{ $producto->id_producto }}"
          data-nombre="{{ $producto->nombre }}" 
          data-precio="{{ $producto->precio }}"
          onclick="agregarAlCarrito('{{ addslashes($producto->nombre) }}', {{ $producto->precio }}, {{ $producto->id_producto }})">
          Agregar al carrito
        </button>

              </div>
            </div>
            @endforeach
          </div>
          <div class="paginacion">
            {{ $productos->links('vendor.pagination.default') }}
          </div>
        </section>
      </div>