// ============================================
// Carrusel de "Nuestros Favoritos"
// ============================================
document.addEventListener('DOMContentLoaded', () => {
  const track = document.getElementById('carouselTrack');
  const leftBtn = document.querySelector('.carousel-arrow.left');
  const rightBtn = document.querySelector('.carousel-arrow.right');

  if (!track || !leftBtn || !rightBtn) return;

  const scrollAmount = () => {
    const card = track.querySelector('.product-card');
    return card ? card.offsetWidth + 20 : 220; // 20 = gap entre tarjetas
  };

  leftBtn.addEventListener('click', () => {
    track.scrollBy({ left: -scrollAmount(), behavior: 'smooth' });
  });

  rightBtn.addEventListener('click', () => {
    track.scrollBy({ left: scrollAmount(), behavior: 'smooth' });
  });
});