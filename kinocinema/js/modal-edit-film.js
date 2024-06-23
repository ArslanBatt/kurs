// Функция для открытия модального окна редактирования фильма
function openEditFilmModal(filmId) {
  const editFilmModal = document.querySelector('.edit_film');
  const editFilmModalContent = document.querySelector('.edit_film .modal-container');
  const editFilmIdInput = document.getElementById('editFilmId');
  const editNameInput = document.getElementById('edit_name_film');
  const editDurationInput = document.getElementById('edit_duration');
  const editGenresInput = document.getElementById('edit_genres');
  const editDirectorInput = document.getElementById('edit_director');
  const editCastInput = document.getElementById('edit_cast');
  const editTrailerInput = document.getElementById('edit_trailer');
  const editDescriptionInput = document.getElementById('edit_description');
  const editPosterInput = document.getElementById('edit_poster');
  const editFonInput = document.getElementById('edit_fon');
  const editStatusInput = document.getElementById('edit_status');

  // Заполнение модального окна данными фильма
  fetch('../database/get_film_data.php?id=' + filmId)
    .then(response => response.json())
    .then(data => {
      editFilmIdInput.value = data.film.id_film_session;
      editNameInput.value = data.film.name_film;
      editDurationInput.value = data.film.duration;
      editGenresInput.value = data.film.genres;
      editDirectorInput.value = data.film.director;
      editCastInput.value = data.film.cast;
      editTrailerInput.value = data.film.trailer;
      editDescriptionInput.value = data.film.description;
      editStatusInput.value = data.film.status;
    })
    .catch(error => {
      console.error('Ошибка получения данных о фильме:', error);
    });

  // Открытие модального окна
  editFilmModal.classList.add('active');
  editFilmModal.style.animation = 'fadeIn 0.3s ease-in-out';

  // Блокировка прокрутки body при открытом модальном окне
  document.body.style.overflow = 'hidden';

  // Закрытие модального окна при клике вне его области
  editFilmModal.addEventListener('click', (event) => {
    if (event.target === editFilmModal) {
      closeEditFilmModal();
    }
  });

  // Закрытие модального окна при клике на контент
  editFilmModalContent.addEventListener('click', (event) => {
    event.stopPropagation();
  });
}

// Функция для закрытия модального окна
function closeEditFilmModal() {
  const editFilmModal = document.querySelector('.edit_film');
  editFilmModal.classList.remove('active');
  document.body.style.overflow = 'auto';
}