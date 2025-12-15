<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="{{ asset('css/estiloinve.css') }}">
</head>
<body>
    <div class="container">
        <aside class="sidebar">
            <div class="logo">
                <img src="{{ asset('imagenes/19e743dc-8b04-43b4-ad4b-da5ba6b4e109.png') }}" alt="Logo" class="logo-img">
            </div>
            <ul class="nav-links">
                <li><a href="{{ url('privado/home') }}">Home</a></li>
                <li><a href="{{ route('inventario.index') }}">Inventario</a></li>
                <li><a href="{{ asset('privado/usuarios') }}">Usuarios</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <div class="header">
                <h1>EDITAR PRODUCTO</h1>
            </div>

            @if(session('success'))
                <div class="flash-message success" style="max-width:900px;margin:10px auto;padding:10px;background:#e6ffed;border:1px solid #b2f5c6;color:#064e2a;">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="flash-message error" style="max-width:900px;margin:10px auto;padding:10px;background:#ffe6e6;border:1px solid #f5b2b2;color:#6a0410;">
                    {{ session('error') }}
                </div>
            @endif

            <section class="seccion_formulario">
                <div class="card" style="max-width:950px;margin:20px auto;padding:20px;background:#fff;border-radius:8px;">
                    <form action="{{ route('inventario.update', $producto->id_producto) }}" method="POST" enctype="multipart/form-data" class="form-grid">
                        @csrf
                        <div class="form-row">
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $producto->nombre) }}" required>
                        </div>

                        <div class="form-row">
                            <label for="precio">Precio</label>
                            <input type="number" step="0.01" name="precio" id="precio" value="{{ old('precio', $producto->precio) }}" required>
                        </div>

                        <div class="form-row">
                            <label for="stock">Stock</label>
                            <input type="number" name="stock" id="stock" value="{{ old('stock', $producto->stock ?? 0) }}">
                        </div>

                        <div class="form-row">
                            <label for="id_categoria">Categoría</label>
                            <select name="id_categoria" id="id_categoria">
                                <option value="">-- Seleccionar --</option>
                                @foreach($categorias as $cat)
                                    <option value="{{ $cat->id_categoria }}" {{ (old('id_categoria', $producto->id_categoria) == $cat->id_categoria) ? 'selected' : '' }}>{{ $cat->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-row">
                            <label for="id_proveedor">Proveedor</label>
                            <select name="id_proveedor" id="id_proveedor">
                                <option value="">-- Seleccionar --</option>
                                @foreach($proveedores as $prov)
                                    <option value="{{ $prov->id_proveedor }}" {{ (old('id_proveedor', $producto->id_proveedor) == $prov->id_proveedor) ? 'selected' : '' }}>{{ $prov->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-row form-row-full">
                            <label for="descripcion">Descripción</label>
                            <textarea name="descripcion" id="descripcion" rows="4">{{ old('descripcion', $producto->descripcion) }}</textarea>
                        </div>

                        <div class="form-row">
                            <label>Imagen actual</label>
                            @if(!empty($producto->imagen))
                                <img src="{{ asset('storage/' . $producto->imagen) }}" alt="Imagen" class="img-preview" style="max-width:220px;display:block;margin-bottom:8px;">
                            @else
                                <div>Sin imagen</div>
                            @endif
                        </div>

                        <div class="form-row">
                            <label for="imagen">Cambiar imagen</label>
                            <input type="file" name="imagen" id="imagen" accept="image/*">
                        </div>

                        <div class="form-row form-actions" style="grid-column:1/-1;display:flex;gap:12px;justify-content:flex-end;">
                            <a href="{{ route('inventario.index') }}" class="boton-cancelar" style="align-self:center;padding:8px 12px;background:#f3f3f3;border-radius:6px;text-decoration:none;color:#333;">Cancelar</a>
                            <button type="submit" class="boton-guardar" style="padding:8px 16px;background:#1e8f4a;color:#fff;border-radius:6px;border:none;">Actualizar</button>
                        </div>
                    </form>

                    @if ($errors->any())
                        <div class="errors" style="margin-top:12px;color:#a00;">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </section>
        </main>
    </div>
    <script>
        (function(){
            var css = '\n.form-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:16px;align-items:start;}\n.form-row label{display:block;margin-bottom:6px;font-weight:600;}\n.form-row input[type=text], .form-row input[type=number], .form-row select, .form-row textarea{width:100%;padding:8px;border:1px solid #ddd;border-radius:6px;}\n.form-row-full{grid-column:1/-1;}\n.img-preview{max-width:220px;}\n@media(max-width:800px){.form-grid{grid-template-columns:1fr;} }\n';
            var s=document.createElement('style');s.innerHTML=css;document.head.appendChild(s);
        })();
    </script>
</body>
</html>
