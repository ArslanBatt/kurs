<?php 
require_once "header.php";
require_once "database/Connect.php";

// Создание подключения к базе данных
$db = new Connect();
$connection = $db->getConnection();

// Получение фильмов со статусом 0 (скоро)
$sql = "SELECT * FROM film_session WHERE status = '0'";
$result = mysqli_query($connection, $sql);

?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Скоро</title>
  <link rel="stylesheet" href="css/soon.css">
</head>

<main>

<div class="container">
    <span class="title">Расписание и билеты</span>
</div>

<div class="line-container">
  <div class="line"></div>
</div>

<div class="container-move">

<?php
// Проверка наличия результатов
if (mysqli_num_rows($result) > 0) {
    // Вывод каждого фильма
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="movie-poster">';
        echo '<img src="img/films/' . htmlspecialchars($row['poster']) . '" alt="Постер фильма">';
        echo '<div class="movie-info">';
        echo '<p class="title-move">' . htmlspecialchars($row['name_film']) . '</p>';
        echo '<p class="duration">Описание: ' . htmlspecialchars($row['description']) . '</p>';
        echo '<p class="description">Режжисёр' . htmlspecialchars($row['director']) . '</p>';
        echo '<div class="showtimes">';
        echo '<div class="notification">Скоро в прокате</div>';
        echo '</div>'; // .showtimes
        echo '</div>'; // .movie-info
        echo '</div>'; // .movie-poster
    }
} else {
    echo '<p>Нет фильмов, которые скоро выйдут в прокат.</p>';
}
?>

</div> <!-- .container-move -->

<div class="line"></div>

</main>

<?php 
require_once "footer.php";
?>
