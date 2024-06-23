const slides = document.querySelectorAll('.slide');
const dots = document.querySelectorAll('.dot');
let currentSlide = 0;

const showSlide = (n) => {
  slides[currentSlide].classList.remove('active');
  dots[currentSlide].classList.remove('active');

  currentSlide = (n + slides.length) % slides.length;

  slides[currentSlide].classList.add('active');
  dots[currentSlide].classList.add('active');
}

const nextSlide = () => {
  showSlide(currentSlide + 1);
}

// Автоматическое переключение слайдов (опционально)
setInterval(nextSlide, 3000); 

// Обработчики событий для точек
dots.forEach((dot, index) => {
  dot.addEventListener('click', () => {
    showSlide(index);
  });
});

showSlide(currentSlide); // Показать первый слайд при загрузке страницы
