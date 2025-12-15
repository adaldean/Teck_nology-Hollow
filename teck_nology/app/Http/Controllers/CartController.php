<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    // Add product to session cart
    public function add(Request $request)
    {
        $request->validate([
            'id' => 'nullable|integer',
            'nombre' => 'required|string',
            'precio' => 'required|numeric',
            'cantidad' => 'nullable|integer|min:1'
        ]);

        $cart = session()->get('cart', []);

        $id = $request->input('id');
        $nombre = $request->input('nombre');
        $precio = $request->input('precio');
        $cantidad = $request->input('cantidad', 1);

        // Try to find existing item by id if present, otherwise by name
        $foundKey = null;
        foreach ($cart as $key => $item) {
            if ($id && isset($item['id']) && $item['id'] == $id) { $foundKey = $key; break; }
            if (!$id && isset($item['nombre']) && $item['nombre'] === $nombre) { $foundKey = $key; break; }
        }

        if ($foundKey !== null) {
            $cart[$foundKey]['cantidad'] += $cantidad;
        } else {
            $cart[] = [
                'id' => $id,
                'nombre' => $nombre,
                'precio' => (float)$precio,
                'cantidad' => (int)$cantidad,
            ];
        }

        session()->put('cart', $cart);

        // Enrich cart items for JSON response (include image URL if available)
        $detailed = [];
        foreach ($cart as $item) {
            $detail = $item;
            $imgUrl = null;
            if (!empty($item['id'])) {
                $prod = Producto::find($item['id']);
                if ($prod) {
                    $img = $prod->imagen ?? null;
                    if ($img) {
                        if (Str::startsWith($img, 'productos/') || Str::startsWith($img, 'storage/')) {
                            $clean = preg_replace('/^storage\//', '', $img);
                            $imgUrl = asset('storage/' . $clean);
                        } else {
                            $imgUrl = asset('imagenes/' . $img);
                        }
                    }
                }
            }
            $detail['imagen_url'] = $imgUrl;
            $detailed[] = $detail;
        }

        // return cart summary
        $totalItems = array_sum(array_column($cart, 'cantidad'));
        return response()->json(['success' => true, 'count' => $totalItems, 'cart' => $detailed]);
    }

    // Show cart page
    public function show()
    {
        $cart = session()->get('cart', []);

        // Enrich cart items with product data when possible (image, slug, etc.)
        $detailed = [];
        foreach ($cart as $item) {
            $detail = $item;
            $imgUrl = null;
            if (!empty($item['id'])) {
                $prod = Producto::find($item['id']);
                if ($prod) {
                    $img = $prod->imagen ?? null;
                    if ($img) {
                        if (Str::startsWith($img, 'productos/') || Str::startsWith($img, 'storage/')) {
                            $clean = preg_replace('/^storage\//', '', $img);
                            $imgUrl = asset('storage/' . $clean);
                        } else {
                            $imgUrl = asset('imagenes/' . $img);
                        }
                    }
                    // add product slug or extra if needed
                    $detail['producto_id'] = $prod->id_producto;
                }
            }
            $detail['imagen_url'] = $imgUrl;
            $detailed[] = $detail;
        }

        return view('carrito', ['cart' => $detailed]);
    }

    // Return cart item count
    public function count()
    {
        $cart = session()->get('cart', []);
        $totalItems = array_sum(array_column($cart, 'cantidad'));
        return response()->json(['count' => $totalItems]);
    }

    // Update quantity for an item (by id or name)
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'nullable|integer',
            'nombre' => 'nullable|string',
            'cantidad' => 'required|integer|min:0'
        ]);

        $cart = session()->get('cart', []);
        $id = $request->input('id');
        $nombre = $request->input('nombre');
        $cantidad = (int)$request->input('cantidad');

        foreach ($cart as $key => $item) {
            if ($id && isset($item['id']) && $item['id'] == $id) {
                if ($cantidad <= 0) {
                    unset($cart[$key]);
                } else {
                    $cart[$key]['cantidad'] = $cantidad;
                }
                break;
            }
            if (!$id && isset($item['nombre']) && $item['nombre'] === $nombre) {
                if ($cantidad <= 0) {
                    unset($cart[$key]);
                } else {
                    $cart[$key]['cantidad'] = $cantidad;
                }
                break;
            }
        }

        // reindex
        $cart = array_values($cart);
        session()->put('cart', $cart);

        // Build enriched response
        $detailed = [];
        foreach ($cart as $item) {
            $detail = $item;
            $imgUrl = null;
            if (!empty($item['id'])) {
                $prod = Producto::find($item['id']);
                if ($prod) {
                    $img = $prod->imagen ?? null;
                    if ($img) {
                        if (Str::startsWith($img, 'productos/') || Str::startsWith($img, 'storage/')) {
                            $clean = preg_replace('/^storage\//', '', $img);
                            $imgUrl = asset('storage/' . $clean);
                        } else {
                            $imgUrl = asset('imagenes/' . $img);
                        }
                    }
                }
            }
            $detail['imagen_url'] = $imgUrl;
            $detailed[] = $detail;
        }

        $totalItems = array_sum(array_column($cart, 'cantidad'));
        return response()->json(['success' => true, 'count' => $totalItems, 'cart' => $detailed]);
    }

    // Remove an item from cart
    public function remove(Request $request)
    {
        $request->validate([
            'id' => 'nullable|integer',
            'nombre' => 'nullable|string'
        ]);

        $cart = session()->get('cart', []);
        $id = $request->input('id');
        $nombre = $request->input('nombre');

        foreach ($cart as $key => $item) {
            if ($id && isset($item['id']) && $item['id'] == $id) { unset($cart[$key]); break; }
            if (!$id && isset($item['nombre']) && $item['nombre'] === $nombre) { unset($cart[$key]); break; }
        }

        $cart = array_values($cart);
        session()->put('cart', $cart);

        // Build enriched response
        $detailed = [];
        foreach ($cart as $item) {
            $detail = $item;
            $imgUrl = null;
            if (!empty($item['id'])) {
                $prod = Producto::find($item['id']);
                if ($prod) {
                    $img = $prod->imagen ?? null;
                    if ($img) {
                        if (Str::startsWith($img, 'productos/') || Str::startsWith($img, 'storage/')) {
                            $clean = preg_replace('/^storage\//', '', $img);
                            $imgUrl = asset('storage/' . $clean);
                        } else {
                            $imgUrl = asset('imagenes/' . $img);
                        }
                    }
                }
            }
            $detail['imagen_url'] = $imgUrl;
            $detailed[] = $detail;
        }

        $totalItems = array_sum(array_column($cart, 'cantidad'));
        return response()->json(['success' => true, 'count' => $totalItems, 'cart' => $detailed]);
    }

    // Checkout: accept payment form, validate and clear cart (mock)
    public function checkout(Request $request)
    {
        $request->validate([
            'origen' => 'required|string',
            'destino' => 'required|string',
            'comision' => 'required|numeric',
            'fecha' => 'required|date'
        ]);

        // In a real app, create order records, process payment gateway, etc.
        $cart = session()->get('cart', []);
        $total = array_sum(array_map(function($i){return $i['precio'] * $i['cantidad'];}, $cart));

        // Persist order and details to DB inside a transaction
        DB::beginTransaction();
        try {
            // Insert pedido
            $pedidoId = DB::table('pedido')->insertGetId([
                'id_cliente' => auth()->check() ? auth()->user()->id ?? null : null,
                'fecha' => $request->fecha,
                'estado' => 'pendiente',
                'metodo_pago' => $request->concepto ?? ($request->tipo_operacion ?? 'desconocido'),
                'total' => $total,
            ]);

            // Insert detalle_pedido for each cart item
            foreach ($cart as $item) {
                DB::table('detalle_pedido')->insert([
                    'id_pedido' => $pedidoId,
                    'id_producto' => $item['id'] ?? null,
                    'cantidad' => $item['cantidad'] ?? 1,
                    'subtotal' => ($item['precio'] ?? 0) * ($item['cantidad'] ?? 1),
                ]);
            }

            DB::commit();

            // Store last payment info for confirmation page
            session()->put('last_payment', [
                'pedido_id' => $pedidoId,
                'origen' => $request->origen,
                'destino' => $request->destino,
                'comision' => $request->comision,
                'fecha' => $request->fecha,
                'total' => $total,
                'items' => $cart,
            ]);

            // Clear cart
            session()->forget('cart');

            return redirect()->route('carrito.confirmation');
        } catch (\Exception $e) {
            DB::rollBack();
            // Log and return back with error
            \Log::error('Checkout failed: ' . $e->getMessage());
            return back()->withErrors(['checkout' => 'No se pudo procesar el pedido. Intenta de nuevo.']);
        }
    }

    public function confirmation()
    {
        $payment = session()->get('last_payment');
        return view('carrito_confirmacion', compact('payment'));
    }
}
