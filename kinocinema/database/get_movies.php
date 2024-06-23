<?php
require_once "Connect.php"; // Подключение к БД и т.д.

// Создайте объект класса Connect
$db = new Connect();
$connection = $db->getConnection(); // Используйте метод getConnection()

// Проверка наличия параметра 'date' в GET-запросе
$selectedDate = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

// SQL-запрос с учетом выбранной даты (используем подготовленные выражения)
$sql = "SELECT * FROM film_session fs 
        JOIN session s ON fs.id_film_session = s.id_film_session
        WHERE s.date = ?";

$stmt = mysqli_prepare($connection, $sql);
if ($stmt) {
  mysqli_stmt_bind_param($stmt, "s", $selectedDate);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  // Проверка наличия результатов
  if (mysqli_num_rows($result) > 0) {
    while ($film = mysqli_fetch_assoc($result)) { 
      ?>
      <a href="films.php?id=<?= $film['id_film_session'] ?>" class="movie-card-link">
        <div class="movie-poster" style="background-image: url('<?= $film['fon'] ?>')">
          <img src="img/films/<?= $film['poster'] ?>" alt="<?= $film['name_film'] ?>">
          <div class="movie-info">
            <p class="title-move"><?= $film['name_film'] ?></p>
            <p class="duration">Время: <?= $film['duration'] ?> мин.</p>
            <p class="description"><?= $film['description'] ?></p>
            <div class="showtimes">
              <?php
              // Добавьте код для вывода времени сеансов, 
              // используя данные из $film (например, $film['time'])
              ?>
            </div>
          </div>
        </div>
      </a>
      <div class="line"></div> 
      <?php
    }
  } else {
    // Сообщение, если нет фильмов на выбранную дату
    echo '<p>На эту дату сеансов нет.</p>'; 
  }
} else {
  // Обработка ошибки при подготовке запроса
  echo "Ошибка: " . mysqli_error($connection); 
}
?>
