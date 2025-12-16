// Client-side catalog search (in-place filtering)
(function(){
  'use strict';

  function normalize(str){
    if(!str) return '';
    return str.toString().toLowerCase()
      .normalize('NFD')
      .replace(/\p{Diacritic}/gu, '')
      .replace(/["'`´^~ºª]/g, '')
      .replace(/\s+/g,' ')
      .trim();
  }

  function debounce(fn, wait){
    let t = null;
    return function(){
      const args = arguments;
      clearTimeout(t);
      t = setTimeout(()=> fn.apply(this, args), wait);
    }
  }

  function matchesQuery(el, tokens){
    // collect searchable fields: product name and price and any data attributes
    const nameEl = el.querySelector('.producto-nombre');
    const name = nameEl ? nameEl.textContent : '';
    const priceEl = el.querySelector('.producto-precio');
    const price = priceEl ? priceEl.textContent : '';
    const dataText = (el.getAttribute('data-nombre') || '') + ' ' + (el.getAttribute('data-id') || '');
    const haystack = normalize(name + ' ' + price + ' ' + dataText);
    // every token must appear
    return tokens.every(tok => haystack.indexOf(tok) !== -1);
  }

  function filterProducts(q){
    const container = document.querySelector('.productos-cuadricula');
    if(!container) return;
    const tiles = Array.from(container.querySelectorAll('.producto-tarjeta'));
    const pag = document.querySelector('.paginacion');

    const query = normalize(q || '');
    if(!query){
      // show all
      tiles.forEach(t => { t.style.display = ''; });
      if(pag) pag.style.display = '';
      return;
    }

    const tokens = query.split(' ').filter(Boolean);
    let anyVisible = false;
    tiles.forEach(t => {
      const ok = matchesQuery(t, tokens);
      t.style.display = ok ? '' : 'none';
      if(ok) anyVisible = true;
    });

    // hide pagination when filtering (we're showing subset client-side)
    if(pag) pag.style.display = anyVisible ? 'none' : 'none';
  }

  document.addEventListener('DOMContentLoaded', function(){
    const input = document.getElementById('catalog-search');
    if(!input) return;
    const handler = debounce(function(e){ filterProducts(e.target.value); }, 180);
    input.addEventListener('input', handler);

    // also allow pressing Escape to clear
    input.addEventListener('keydown', function(e){
      if(e.key === 'Escape'){
        input.value = '';
        filterProducts('');
        input.blur();
      }
    });
  });
})();
