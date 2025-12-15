<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Confirmación de pago</title>
  <link rel="stylesheet" href="{{ asset('css/estilo.css') }}">
</head>
<body>
  <main class="contenido-principal">
    <h1>Pago confirmado</h1>

    @if($payment)
      <p>Origen: {{ $payment['origen'] }}</p>
      <p>Destino: {{ $payment['destino'] }}</p>
      <p>Comisión: ${{ number_format($payment['comision'],2) }}</p>
      <p>Fecha: {{ $payment['fecha'] }}</p>
      <p>Total: ${{ number_format($payment['total'],2) }}</p>

      <h3>Artículos</h3>
      <ul>
        @foreach($payment['items'] as $it)
          <li>{{ $it['cantidad'] }} x {{ $it['nombre'] }} — ${{ number_format($it['precio'],2) }}</li>
        @endforeach
      </ul>
    @else
      <p>No hay información de pago.</p>
    @endif

    <a href="{{ url('/') }}" class="boton-agregar">Volver al inicio</a>
  </main>
</body>
</html>
