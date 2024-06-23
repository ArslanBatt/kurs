  document.addEventListener('DOMContentLoaded', function() {
  const openModalButton = document.querySelector('.open-modal');
  const modal = document.querySelector('.modal');
  const modal2 = document.querySelector('.modal2');
  const overlay = document.querySelector('.overlay');
  const modalRegButton = document.querySelector('.modal-reg');
  const modalSignButton = document.querySelector('.modal-sign');
  const modal2RegButton = document.querySelector('.modal2-reg');
  const modal2SignButton = document.querySelector('.modal2-sign');

  function disableScroll() {
    document.body.style.overflow = 'hidden';
  }

  function enableScroll() {
    document.body.style.overflow = 'auto';
  }

  openModalButton.addEventListener('click', function(event) {
    event.preventDefault();
    modal2.style.display = 'block'; 
    setTimeout(() => { 
      modal2.classList.add('show'); 
    }, 10);
    overlay.classList.add('active');
    disableScroll();
  });

  overlay.addEventListener('click', function() {
    modal.classList.remove('show'); 
    modal2.classList.remove('show'); 
    setTimeout(() => {
      modal.style.display = 'none';
      modal2.style.display = 'none';
    }, 300); 
    overlay.classList.remove('active');
    enableScroll();
  });

  // Меняем местами modal и modal2 в обработчиках кнопок
  modalRegButton.addEventListener('click', function() {
    modal2.classList.remove('show');
    setTimeout(() => {
      modal2.style.display = 'none';
      modal.style.display = 'block';
      setTimeout(() => {
        modal.classList.add('show');
      }, 10);
    }, 300);
  });

  modalSignButton.addEventListener('click', function() {
    modal.classList.remove('show');
    setTimeout(() => {
      modal.style.display = 'none';
      modal2.style.display = 'block';
      setTimeout(() => {
        modal2.classList.add('show');
      }, 10);
    }, 300);
  });

  // Исправленный селектор для modal2RegButton:
  modal2RegButton.addEventListener('click', function() {
    modal2.classList.remove('show');
    setTimeout(() => {
      modal2.style.display = 'none';
      modal.style.display = 'block';
      setTimeout(() => {
        modal.classList.add('show');
      }, 10);
    }, 300);
  });



  const openAgreementButton = document.querySelector('.open-agreement-button');
  const agreementModalContainer = document.querySelector('.agreement-modal-container');
  const closeAgreementButton = document.querySelector('.close-button');

  openAgreementButton.addEventListener('click', function(event) {
    event.preventDefault();
    agreementModalContainer.style.display = 'block';
    setTimeout(() => {
      agreementModalContainer.classList.add('show');
    }, 10);
  });

  // Закрытие по клику вне модального окна:
  agreementModalContainer.addEventListener('click', function(event) {
    if (event.target === agreementModalContainer) {
      agreementModalContainer.classList.remove('show');
      setTimeout(() => {
        agreementModalContainer.style.display = 'none';
      }, 300);
    }
  });

  closeAgreementButton.addEventListener('click', function() {
    agreementModalContainer.classList.remove('show');
    setTimeout(() => {
      agreementModalContainer.style.display = 'none';
    }, 300);
  });



  modal2SignButton.addEventListener('click', function() {
    modal.classList.remove('show');
    setTimeout(() => {
      modal.style.display = 'none';
      modal2.style.display = 'block';
      setTimeout(() => {
        modal2.classList.add('show');
      }, 10);
    }, 300);
  });
});