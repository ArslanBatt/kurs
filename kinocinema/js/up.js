const backToTopBtn = document.getElementById('back-to-top-btn');

// Показываем кнопку при прокрутке вниз
window.addEventListener('scroll', () => {
  if (window.pageYOffset > 300) { // Показываем кнопку после 300px прокрутки 
    backToTopBtn.classList.add('show');
  } else {
    backToTopBtn.classList.remove('show');
  }
});

// Плавный скролл наверх при клике
backToTopBtn.addEventListener('click', () => {
  window.scrollTo({
    top: 0,
    behavior: 'smooth' // Плавная прокрутка
  });
});