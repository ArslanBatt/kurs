// modal_hall.js

const timeButtons = document.querySelectorAll('.time');

timeButtons.forEach(button => {
  button.addEventListener('click', function() {
    const ticketModal = document.getElementById("ticketModal");
    ticketModal.style.display = "block";
    document.body.style.overflow = "hidden";

    const filmTitle = document.getElementById("movieTitle").textContent;
    const sessionDate = button.closest('.session-date').querySelector('h3').textContent.trim();
    const selectedTime = button.dataset.time;
    const hallName = button.dataset.hall;

    document.getElementById("modalFilmTitle").textContent = filmTitle;
    document.getElementById("modalSessionInfo").textContent = `${sessionDate} / ${hallName} / ${selectedTime}`;
    
    // Сохраняем данные сеанса в атрибутах data для последующего использования
    document.getElementById("ticketModal").dataset.sessionId = button.dataset.sessionId;

    // Здесь можно сделать запрос для получения занятых мест на текущий сеанс и обновить UI
    fetch(`../database/get_booked_seats.php?sessionId=${button.dataset.sessionId}`)
      .then(response => response.json())
      .then(data => {
        const seats = document.querySelectorAll('.seat');
        seats.forEach(seat => {
          const seatIndex = seat.dataset.seatIndex;
          if (data.bookedSeats.includes(parseInt(seatIndex))) {
            seat.classList.add('seat-occupied');
            seat.classList.remove('seat-selected', 'seat-available');
          } else {
            seat.classList.add('seat-available');
            seat.classList.remove('seat-occupied', 'seat-selected');
          }
        });
      })
      .catch(error => {
        console.error('Ошибка при получении забронированных мест:', error);
      });
  });
});

const closeModalButton = document.querySelector(".modal_hall .close");

closeModalButton.addEventListener('click', function(event) {
  const ticketModal = document.getElementById("ticketModal");
  ticketModal.style.display = "none";
  document.body.style.overflow = "";
});

window.addEventListener('click', function(event) {
  const ticketModal = document.getElementById("ticketModal");
  if (event.target === ticketModal) {
    ticketModal.style.display = "none";
    document.body.style.overflow = "";
  }
});

const seats = document.querySelectorAll('.seat-available');
seats.forEach(seat => {
  seat.addEventListener('click', function() {
    // Переключение состояния выбора места
    if (!seat.classList.contains('seat-occupied')) {
      seat.classList.toggle('seat-selected');
    }
  });
});

const buyButton = document.querySelector('.buy-button');
buyButton.addEventListener('click', function() {
  const selectedSeats = document.querySelectorAll('.seat-selected');
  if (selectedSeats.length === 0) {
    alert('Пожалуйста, выберите хотя бы одно место.');
    return;
  }

  const seatData = Array.from(selectedSeats).map(seat => ({
    row: seat.dataset.row,
    seat: seat.dataset.seat
  }));

  const sessionId = document.getElementById("ticketModal").dataset.sessionId;

  fetch('../database/book_seat.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      sessionId: sessionId,
      seats: seatData
    })
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      alert('Билеты успешно забронированы!');
      // По желанию можно обновить страницу или изменить UI
      location.reload();
    } else {
      alert('Ошибка при бронировании билетов.');
    }
  })
  .catch(error => {
    console.error('Ошибка:', error);
  });
});
