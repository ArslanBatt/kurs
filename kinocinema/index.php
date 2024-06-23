<?php
require_once "header.php";

$sql = "SELECT * FROM film_session";
$result = mysqli_query($connection, $sql);

?>

<head>  
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Главная</title>
  <link rel="stylesheet" href="css/main.css">
</head>

<main>

  <div class="outer-block">
    <div class="inner-block">
      <div class="slider">
        <div class="slide">
          <img src="img/sliders/dep.jpg" alt="Слайд 1">
        </div>
        <div class="slide">
          <img src="img/sliders/unchar.jpg" alt="Слайд 2">
        </div>
        <div class="slide">
          <img src="img/sliders/интер.webp" alt="Слайд 3">
        </div>
      </div>
      <div class="dots">
        <span class="dot active"></span>
        <span class="dot"></span>
        <span class="dot"></span>
      </div>
    </div>
  </div>


  <div class="container">
    <span class="title">Расписание и билеты</span>

    <select class="rounded-select">
      <option value="">Сортировка по</option>
      <option value="moscow">Новизне</option>
      <option value="spb">Цене</option>
    </select>
  </div>


  <div class="line-container">
    <div class="line"></div>
  </div>




  <div class="calendar"> 
  <button class="arrow left-arrow" id="prevWeek"><img src="img/weeks/left.png" alt=""></button> 
  <div class="calendar-content"> 
    <div class="days"> 
      </div> 
  </div> 
  <button class="arrow right-arrow" id="nextWeek"><img src="img/weeks/right.png" alt=""></button> 
</div> 

<div class="container-move" id="movie-list"> 
  <!-- Здесь будут загружаться фильмы --> 
</div> 

</main> 

<script src="/js/week.js"></script> 

<script src="/js/slider.js"></script>

<script>
  function loadMovies(date) {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "../database/get_movies.php?date=" + date, true);
    xhr.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        // Добавляем анимацию появления
        const movieList = document.getElementById("movie-list");
        movieList.innerHTML = ""; // Очищаем список перед добавлением
        const newMovies = this.responseText;
        movieList.innerHTML = newMovies; 
        const movieCards = document.querySelectorAll('.movie-card-link');
        movieCards.forEach((card, index) => {
          card.style.opacity = '0';
          card.style.transform = 'translateX(50px)'; // Начальное смещение
          setTimeout(() => {
            card.style.transition = `opacity 0.5s ease, transform 0.5s ease ${index * 0.1}s`;
            card.style.opacity = '1';
            card.style.transform = 'translateX(0)';
          }, 100);
        });
      }
    };
    xhr.send();
  }

  loadMovies(new Date().toISOString().slice(0, 10));
</script>


<?php

require_once "footer.php";

?>