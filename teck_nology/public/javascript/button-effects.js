// Small ripple + hover microinteractions for dynamic buttons
(function(){
  if (typeof window === 'undefined') return;

  function createRipple(e){
    const btn = e.currentTarget;
    const rect = btn.getBoundingClientRect();
    const ripple = document.createElement('span');
    const size = Math.max(rect.width, rect.height) * 1.6;
    const x = (e.clientX || (e.touches && e.touches[0].clientX)) - rect.left - size/2;
    const y = (e.clientY || (e.touches && e.touches[0].clientY)) - rect.top - size/2;
    ripple.style.position = 'absolute';
    ripple.style.left = x + 'px';
    ripple.style.top = y + 'px';
    ripple.style.width = ripple.style.height = size + 'px';
    ripple.style.borderRadius = '50%';
    ripple.style.background = 'rgba(255,255,255,0.28)';
    ripple.style.transform = 'scale(0)';
    ripple.style.pointerEvents = 'none';
    ripple.style.transition = 'transform 520ms cubic-bezier(.2,.9,.2,1), opacity 520ms ease';
    ripple.style.opacity = '0.95';
    ripple.className = 'btn-ripple';
    btn.style.position = btn.style.position || 'relative';
    btn.appendChild(ripple);
    requestAnimationFrame(()=>{ ripple.style.transform = 'scale(1)'; ripple.style.opacity = '0'; });
    setTimeout(()=>{ try{ btn.removeChild(ripple); }catch(e){} }, 700);
  }

  function bind(){
    const selectors = ['.btn-dynamic', '.agregar-carrito', 'button', 'a.btn-dynamic'];
    const els = document.querySelectorAll(selectors.join(','));
    els.forEach(el=>{
      el.addEventListener('mousedown', createRipple);
      el.addEventListener('touchstart', createRipple, {passive:true});
      // keyboard support visual on focus
      el.addEventListener('keydown', (e)=>{
        if (e.key === 'Enter' || e.key === ' ') {
          // fake a center ripple
          const rect = el.getBoundingClientRect();
          const fake = { currentTarget: el, clientX: rect.left + rect.width/2, clientY: rect.top + rect.height/2 };
          createRipple(fake);
        }
      });
    });
  }

  document.addEventListener('DOMContentLoaded', bind);
})();
