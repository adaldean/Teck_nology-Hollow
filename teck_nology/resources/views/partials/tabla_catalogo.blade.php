<div class="contenido-principal">
  <section class="area-productos">
    <!-- Mirage helpers (sheen + vignette) to give the catalog a reflected floor effect -->
    <div class="espejismo-sheen" aria-hidden="true"></div>
    <div class="vignette" aria-hidden="true"></div>
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
            // Prefer static images from public/imagenes for the catalog in this fixed mapping order
            $default = asset('imagenes/19e743dc-8b04-43b4-ad4b-da5ba6b4e109.png');
            $nombre = $producto->nombre ?? '';
            $lower = mb_strtolower($nombre);

            $map = [
              'gta v' => 'GTAV.png',
              'gta' => 'GTAV.png',
              'iphone 13' => 'imagen3.png',
              'cable cargador tipo c' => 'cargadortipoc.png',
              'cargador tipo c' => 'cargadortipoc.png',
              'laptop asus' => 'laptopasus.png',
              'laptop victus' => 'imagen4.png',
              'iphone 16' => 'iphone16.png',
            ];

            $src = $default;
            foreach ($map as $needle => $file) {
        if (mb_stripos($lower, mb_strtolower($needle)) !== false) {
          // Use helper route to serve frontend images (no DB required)
          $src = url('/imagenes/static/' . $file);
                    break;
                }
            }

            // If mapping didn't match but the product has an image path, try to resolve it as before
            if ($src === $default && !empty($producto->imagen)) {
                $img = $producto->imagen;
                if (\Illuminate\Support\Str::startsWith($img, 'productos/') || \Illuminate\Support\Str::startsWith($img, 'storage/')) {
                    $clean = preg_replace('/^storage\//', '', $img);
                    $src = asset('storage/' . $clean);
                } else {
                    $src = asset('imagenes/' . $img);
                }
            }
          @endphp
          <img src="{{ $src }}" alt="{{ $producto->nombre }}" loading="lazy">
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