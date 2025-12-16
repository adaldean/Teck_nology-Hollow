// Quickview modal for catalog products
(function(){
  'use strict';

  function openQuickview(data){
    const modal = document.getElementById('quickview-modal');
    if(!modal) return;
    modal.querySelector('.qv-image').src = data.img || '';
    modal.querySelector('.qv-title').textContent = data.nombre || '';
    modal.querySelector('.qv-price').textContent = data.precio ? ('$' + Number(data.precio).toFixed(2)) : '';
    modal.querySelector('.qv-desc').textContent = data.desc || '';
    modal.setAttribute('data-product-id', data.id || '');
    modal.classList.add('show');
    modal.style.display = 'flex';
    // trap focus optional
  }

  function closeQuickview(){
    const modal = document.getElementById('quickview-modal');
    if(!modal) return;
    modal.classList.remove('show');
    setTimeout(()=>{ modal.style.display = 'none'; }, 300);
  }

  document.addEventListener('click', function(e){
    // open when clicking on product card or image
    const img = e.target.closest('.quickview-trigger');
    if(img){
      const card = img.closest('.producto-tarjeta');
      if(card){
        openQuickview({
          id: card.getAttribute('data-id'),
          nombre: card.getAttribute('data-nombre'),
          precio: card.getAttribute('data-precio'),
          desc: card.getAttribute('data-desc'),
          img: img.getAttribute('src')
        });
      }
      return;
    }
    const card = e.target.closest('.producto-tarjeta');
    if(card && !e.target.closest('button') && !e.target.closest('a')){
      // clicking anywhere on the card (but not buttons/links)
      const imgEl = card.querySelector('img') || {};
      openQuickview({
        id: card.getAttribute('data-id'),
        nombre: card.getAttribute('data-nombre'),
        precio: card.getAttribute('data-precio'),
        desc: card.getAttribute('data-desc'),
        img: imgEl.getAttribute('src')
      });
      return;
    }

    // close when clicking close button or overlay
    if(e.target.matches('#quickview-modal .qv-close') || e.target.id === 'quickview-modal'){
      closeQuickview();
    }

    // add to cart from modal
    if(e.target.matches('#quickview-modal .qv-add')){
      const modal = document.getElementById('quickview-modal');
      const id = modal && modal.getAttribute('data-product-id');
      const nombre = modal.querySelector('.qv-title')?.textContent || '';
      const precioText = modal.querySelector('.qv-price')?.textContent || '';
      const precio = precioText.replace(/[^0-9.,]/g,'').replace(',','.') || 0;
      // use existing agregarAlCarrito function if available
      if(typeof agregarAlCarrito === 'function'){
        agregarAlCarrito(nombre, parseFloat(precio) || 0, id);
      }
      closeQuickview();
    }
  });

  // keyboard support: Esc to close
  document.addEventListener('keydown', function(e){ if(e.key === 'Escape'){ closeQuickview(); } });

})();
