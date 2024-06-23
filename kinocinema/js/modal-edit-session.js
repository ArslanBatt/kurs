// Функция для открытия модального окна редактирования 
function openEditModal(sessionId) {
  const editSessionModal = document.querySelector('.edit_session');
  const editSessionModalContent = document.querySelector('.edit_session .modal-container'); // Выбираем контент модального окна
  const editSessionIdInput = document.getElementById('editSessionId');
  const editHallSelect = document.getElementById('editHall');
  const editFilmSelect = document.getElementById('editFilm');
  const editDateInput = document.getElementById('editDate');
  const editTimeInput = document.getElementById('editTime');
  const editPriceInput = document.getElementById('editPrice');

  // Заполнение модального окна данными сеанса 
  fetch('../database/get_session_data.php?id=' + sessionId)
    .then(response => response.json())
    .then(data => {
      editSessionIdInput.value = data.session.id_session;

      // Добавление опций для залов
      editHallSelect.innerHTML = ''; // Очистка существующих опций
      data.halls.forEach(hall => {
        let option = document.createElement('option');
        option.value = hall.id_hall;
        option.text = hall.name;
        editHallSelect.add(option);
      });
      editHallSelect.value = data.session.id_hall;

      // Добавление опций для фильмов
      editFilmSelect.innerHTML = ''; // Очистка существующих опций
      data.films.forEach(film => {
        let option = document.createElement('option');
        option.value = film.id_film_session;
        option.text = film.name_film;
        editFilmSelect.add(option);
      });
      editFilmSelect.value = data.session.id_film_session; // Выбор фильма

      editDateInput.value = data.session.date;
      editTimeInput.value = data.session.time;
      editPriceInput.value = data.session.price;
      
    })
    .catch(error => {
      console.error('Ошибка получения данных о сеансе:', error);
    });

  // Открытие модального окна 
  editSessionModal.classList.add('active');
  editSessionModal.style.animation = 'fadeIn 0.3s ease-in-out';

  // Блокировка прокрутки body при открытом модальном окне
  document.body.style.overflow = 'hidden';

  // Закрытие модального окна при клике вне его области
  editSessionModal.addEventListener('click', (event) => {
    if (event.target === editSessionModal) { // Проверяем, клик был именно по фону модального окна
      closeEditModal();
    }
  });

  // Закрытие модального окна при клике на контент
  editSessionModalContent.addEventListener('click', (event) => {
    event.stopPropagation(); // Останавливаем всплытие события, чтобы оно не закрывало модальное окно при клике на контент
  });
}

// Функция для закрытия модального окна
function closeEditModal() {
  const editSessionModal = document.querySelector('.edit_session');
  editSessionModal.classList.remove('active');
  // Разблокировка прокрутки body
  document.body.style.overflow = 'auto';
}