function formatDate(date, time) {
    const day = date.getDate();
    const monthIndex = date.getMonth();

    // Массив с названиями месяцев
    const monthNames = [
        "января", "февраля", "марта", "апреля", "мая", "июня",
        "июля", "августа", "сентября", "октября", "ноября", "декабря"
    ];

    // Получаем текущее время (часы и минуты)
    const hours = time.slice(0, 2);
    const minutes = time.slice(3, 5);

    // Формируем строку даты в формате "День Месяц, Часы:Минуты"
    return day + " " + monthNames[monthIndex] + ", " + hours + ":" + minutes;
}

// Получаем сегодняшнюю дату
const today = new Date();

// Находим все элементы с классом 'session-date'
const sessionDates = document.querySelectorAll('.session-date');

// Устанавливаем даты для каждого блока
sessionDates.forEach((dateElement, index) => {
    let dateToShow = new Date(today);
    dateToShow.setDate(today.getDate() + index); // Прибавляем дни для следующих дат

    // Находим заголовок h3 в текущем элементе session-date
    const dateHeader = dateElement.querySelector('h3');
    if (!dateHeader) return; // Проверяем наличие заголовка, чтобы избежать ошибки

    const dateKey = dateHeader.textContent.trim();

    // Находим все элементы с классом 'showtimes' в текущем session-date
    const sessions = dateElement.querySelectorAll('.showtimes');
    if (!sessions) return; // Проверяем наличие сеансов

    // Обходим каждый сеанс и устанавливаем отформатированную дату
    sessions.forEach(session => {
        const sessionTimeElement = session.querySelector('.time');
        if (!sessionTimeElement) return; // Проверяем наличие элемента времени

        const sessionTime = sessionTimeElement.getAttribute('data-time');
        const sessionDateElement = session.previousElementSibling.querySelector('h3');
        if (!sessionDateElement) return; // Проверяем наличие элемента даты сеанса

        const sessionDate = sessionDateElement.textContent.trim();
        if (dateKey === sessionDate) {
            const formattedDate = formatDate(dateToShow, sessionTime);
            sessionTimeElement.textContent = formattedDate;
        }
    });
});
