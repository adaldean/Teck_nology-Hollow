@if ($paginator->hasPages())
    <div class="paginacion">
        {{-- Botón anterior --}}
        @if ($paginator->onFirstPage())
            <span class="pagina-btn anterior-btn" aria-disabled="true" aria-label="Anterior">‹ Anterior</span>
        @else
            <a class="pagina-btn anterior-btn" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Página anterior">‹ Anterior</a>
        @endif

        {{-- Números de página --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span>{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <a href="#" class="pagina-btn pagina-actual" aria-current="page">{{ $page }}</a>
                    @else
                        <a class="pagina-btn" href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Botón siguiente --}}
        @if ($paginator->hasMorePages())
            <a class="pagina-btn siguiente-btn" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Página siguiente">Siguiente ›</a>
        @else
            <span class="pagina-btn siguiente-btn" aria-disabled="true" aria-label="Siguiente">Siguiente ›</span>
        @endif
    </div>
@endif
