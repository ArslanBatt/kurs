const addButton = document.querySelector('.add-button'); 
const creatSessionModal = document.querySelector('.modal-overlay'); 
const closeButton = document.querySelector('.close-button'); 

// Функция для блокировки прокрутки
function disableScrolling() {
  document.body.style.overflow = 'hidden';
}

// Функция для разблокировки прокрутки
function enableScrolling() {
  document.body.style.overflow = 'auto'; 
}

addButton.addEventListener('click', () => { 
  creatSessionModal.classList.add('active'); 
  creatSessionModal.style.animation = 'fadeIn 0.3s ease-in-out'; 
  disableScrolling(); // Блокируем прокрутку при открытии
}); 

closeButton.addEventListener('click', () => { 
  creatSessionModal.classList.remove('active'); 
  creatSessionModal.style.animation = 'fadeOut 0.3s ease-in-out'; 
  enableScrolling(); // Разблокируем прокрутку при закрытии
}); 

// Закрытие модального окна при клике вне его 
creatSessionModal.addEventListener('click', (event) => { 
  if (event.target === creatSessionModal) { 
    creatSessionModal.classList.remove('active'); 
    creatSessionModal.style.animation = 'fadeOut 0.3s ease-in-out'; 
    enableScrolling(); // Разблокируем прокрутку при закрытии
  } 
});
