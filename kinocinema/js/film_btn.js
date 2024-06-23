
// Находим все кнопки "Купить"
const buyButtons = document.querySelectorAll('.time');

// Добавляем обработчик клика для каждой кнопки
buyButtons.forEach(button => {
    button.addEventListener('click', (event) => {
        event.preventDefault(); // Отменяем стандартное поведение ссылки

        const filmId = button.closest('.movie-card-link').dataset.filmId;
        const selectedTime = button.dataset.time;

        // Здесь вы можете добавить код для обработки покупки билета,
        // используя filmId и selectedTime
        console.log("Выбран фильм:", filmId, "на время:", selectedTime);

        // Добавьте сюда код для открытия модального окна или 
        // перенаправления на страницу оформления заказа 
    });
});
