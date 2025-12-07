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
                <img src="{{ asset('imagenes/' . $producto->imagen) }}" alt="{{ $producto->nombre }}">
              </div>
              <div class="producto-info">
                <p class="producto-nombre">{{ $producto->nombre }}</p>
                <p class="producto-precio">${{ $producto->precio }}</p>
                <button class="agregar-carrito" 
                    data-nombre="{{ $producto->nombre }}" 
                    data-precio="{{ $producto->precio }}">
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