@if ($paginator->hasPages())
    <div class="paginacion">
        {{-- Botón anterior --}}
        @if ($paginator->onFirstPage())
            <span>← Anterior</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}">← Anterior</a>
        @endif

        {{-- Números de página --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span>{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <a href="#" class="pagina-actual">{{ $page }}</a>
                    @else
                        <a href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Botón siguiente --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}">Siguiente →</a>
        @else
            <span>Siguiente →</span>
        @endif
    </div>
@endif
