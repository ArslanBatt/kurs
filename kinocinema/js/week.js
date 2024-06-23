const daysOfWeek = ["Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота", "Воскресенье"];
const daysContainer = document.querySelector('.days');
let currentDate = new Date();

// Функция для получения дат текущей недели
function getWeekDates(date) {
  const dayIndex = date.getDay();
  const firstDayOfCurrentWeek = new Date(date);
  firstDayOfCurrentWeek.setDate(date.getDate() - (dayIndex == 0 ? 6 : dayIndex - 1));
  const weekDates = [];
  for (let i = 0; i < 7; i++) {
    const day = new Date(firstDayOfCurrentWeek);
    day.setDate(firstDayOfCurrentWeek.getDate() + i);
    weekDates.push(day);
  }
  return weekDates;
}

// Функция для обновления календаря
function updateCalendar(date) {
  const weekDates = getWeekDates(date);
  daysContainer.innerHTML = '';

  weekDates.forEach((date) => {
    const dayOfWeek = daysOfWeek[date.getDay() === 0 ? 6 : date.getDay() - 1];
    const dayNumber = `${date.getDate()}.${(date.getMonth() + 1).toString().padStart(2, '0')}`;

    const dayElement = document.createElement('div');
    dayElement.classList.add('day');

    if (date.toDateString() === new Date().toDateString()) {
      dayElement.classList.add('current-day');
    }

    dayElement.innerHTML = `    <span class="day-name">${dayOfWeek}</span>
    <span class="day-number">${dayNumber}</span>`;

    dayElement.addEventListener('click', () => {
      const currentDayElement = daysContainer.querySelector('.current-day');
      if (currentDayElement) {
        currentDayElement.classList.remove('current-day');
      }
      dayElement.classList.add('current-day');
      currentDate = date;

      // Вызываем функцию для загрузки фильмов с выбранной датой
      loadMovies(currentDate.toISOString().slice(0, 10)); 
    });

    daysContainer.appendChild(dayElement);
  });
}

  document.getElementById('prevWeek').addEventListener('click', () => { 
    currentDate.setDate(currentDate.getDate() - 7); 
    updateCalendar(currentDate); 
  }); 

  document.getElementById('nextWeek').addEventListener('click', () => { 
    currentDate.setDate(currentDate.getDate() + 7); 
    updateCalendar(currentDate); 
  }); 

  document.getElementById('prevWeek').addEventListener('mouseover', () => {
    document.getElementById('prevWeek').querySelector('img').src = 'img/weeks/left-active.png'; 
    document.getElementById('prevWeek').classList.add('arrow-active'); // Добавляем класс анимации
  });
  
  document.getElementById('prevWeek').addEventListener('mouseout', () => {
    document.getElementById('prevWeek').querySelector('img').src = 'img/weeks/left.png'; 
    document.getElementById('prevWeek').classList.remove('arrow-active'); // Удаляем класс анимации
  });
  
  document.getElementById('nextWeek').addEventListener('mouseover', () => {
    document.getElementById('nextWeek').querySelector('img').src = 'img/weeks/right-active.png'; 
    document.getElementById('nextWeek').classList.add('arrow-active'); // Добавляем класс анимации
  });
  
  document.getElementById('nextWeek').addEventListener('mouseout', () => {
    document.getElementById('nextWeek').querySelector('img').src = 'img/weeks/right.png'; 
    document.getElementById('nextWeek').classList.remove('arrow-active'); // Удаляем класс анимации
  });

  updateCalendar(currentDate);

