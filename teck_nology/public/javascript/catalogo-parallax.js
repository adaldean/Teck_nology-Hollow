// Small, lightweight parallax for product cards.
// Applies a subtle translateY based on the card's position in the viewport.
(function(){
  if (typeof window === 'undefined') return;
  const cards = () => Array.from(document.querySelectorAll('.producto-tarjeta'));
  let raf = null;

  function update() {
    const list = cards();
    const vh = window.innerHeight;
    list.forEach(card => {
      const rect = card.getBoundingClientRect();
      // distance from center of viewport (-1..1)
      const centerDist = ((rect.top + rect.height/2) - (vh/2)) / (vh/2);
      // clamp and compute small translate (max 14px)
      const max = 14;
      const ty = Math.max(-1, Math.min(1, -centerDist)) * (max * 0.6);
      // also a tiny scale for depth
      const sc = 1 - Math.abs(centerDist) * 0.01;
      card.style.transform = `translateY(${ty.toFixed(2)}px) scale(${sc.toFixed(3)})`;
      card.style.willChange = 'transform';
      card.style.transition = 'transform 420ms cubic-bezier(.2,.8,.2,1)';
    });
    raf = null;
  }

  function schedule(){
    if (raf) return;
    raf = requestAnimationFrame(update);
  }

  // initialize on load + scroll + resize
  window.addEventListener('scroll', schedule, { passive: true });
  window.addEventListener('resize', schedule);
  document.addEventListener('DOMContentLoaded', () => {
    // initial small delay to allow images/layout
    setTimeout(schedule, 120);
  });
})();
