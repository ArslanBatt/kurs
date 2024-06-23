// Открываем модальное окно при клике на кнопку "Смотреть трейлер" 
document.getElementById("myBtn").onclick = function() { 
  document.getElementById("myModal").style.display = "block"; 
  // Анимация появится после применения display: block
  setTimeout(() => {
    document.getElementById("myModal").classList.add('show'); 
  }, 10);
  document.body.style.overflow = "hidden";
  document.getElementById("modalMovieTitle").textContent = document.getElementById("movieTitle").textContent; 
}; 

// Закрываем модальное окно 
function closeModal() {
  document.getElementById("myModal").classList.remove('show'); 
  // Задержка перед скрытием больше не нужна 
  document.getElementById("myModal").style.display = "none"; 
  document.body.style.overflow = "auto"; 
  document.getElementById("trailerIframe").src = document.getElementById("trailerIframe").src; 
}

// Закрываем модальное окно при клике на крестик 
document.querySelector(".close-trailer").onclick = closeModal;

// Закрываем модальное окно при клике вне области модального окна 
window.onclick = function(event) { 
  if (event.target == document.getElementById("myModal")) { 
    closeModal();
  } 
};
