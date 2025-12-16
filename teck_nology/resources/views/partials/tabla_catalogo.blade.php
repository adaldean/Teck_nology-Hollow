<div class="contenido-principal">
  <!-- Rain-style decorative dots (shared with login) -->
  <div class="login-decor" aria-hidden="true">
    <span class="dot" style="left:4%; top:-6%; animation-duration:4.8s; animation-delay:0s"></span>
    <span class="dot" style="left:10%; top:-10%; animation-duration:5.6s; animation-delay:0.6s"></span>
    <span class="dot" style="left:16%; top:-8%; animation-duration:6.2s; animation-delay:0.2s"></span>
    <span class="dot" style="left:22%; top:-12%; animation-duration:5.0s; animation-delay:1.1s"></span>
    <span class="dot" style="left:28%; top:-9%; animation-duration:6.8s; animation-delay:0.9s"></span>
    <span class="dot" style="left:34%; top:-14%; animation-duration:4.4s; animation-delay:0.3s"></span>
    <span class="dot" style="left:40%; top:-6%; animation-duration:5.2s; animation-delay:1.6s"></span>
    <span class="dot" style="left:48%; top:-11%; animation-duration:5.9s; animation-delay:0.4s"></span>
    <span class="dot" style="left:56%; top:-7%; animation-duration:6.6s; animation-delay:1.0s"></span>
    <span class="dot" style="left:64%; top:-13%; animation-duration:4.9s; animation-delay:0.8s"></span>
    <span class="dot" style="left:72%; top:-5%; animation-duration:6.0s; animation-delay:1.3s"></span>
    <span class="dot" style="left:78%; top:-9%; animation-duration:5.4s; animation-delay:0.5s"></span>
    <span class="dot" style="left:84%; top:-14%; animation-duration:7.2s; animation-delay:0.7s"></span>
    <span class="dot" style="left:90%; top:-8%; animation-duration:5.1s; animation-delay:1.9s"></span>
  </div>
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
          </div>
          
          <div class="productos-cuadricula">
      @foreach($productos as $producto)
      <div class="producto-tarjeta" data-id="{{ $producto->id_producto }}" data-nombre="{{ e($producto->nombre) }}" data-precio="{{ $producto->precio }}" data-desc="{{ e($producto->descripcion) }}">
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
          <img src="{{ $src }}" alt="{{ $producto->nombre }}" loading="lazy" class="quickview-trigger">
          {{-- hidden description for accessibility / fallback --}}
          <div class="producto-descripcion" style="display:none">{{ $producto->descripcion }}</div>
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
  <!-- Quickview modal (catalog) -->
  <div id="quickview-modal" class="quickview-modal" aria-hidden="true" style="display:none">
    <div class="qv-card">
      <button class="qv-close" aria-label="Cerrar">&times;</button>
      <img src="" alt="" class="qv-image">
      <div class="qv-info">
        <div class="qv-title">Título del producto</div>
        <div class="qv-price">$0.00</div>
        <div class="qv-desc">Descripción del producto</div>
        <button class="qv-add">Agregar al carrito</button>
      </div>
    </div>
  </div>