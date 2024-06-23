<?php 

require_once "../header.php";

// Получаем ID пользователя (предполагаем, что он хранится в сессии)
session_start();
$id_user = $_SESSION['id_user'];

?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Пользователь</title>
  <link rel="stylesheet" href="/css/profile.css">
</head>

<div class="button-container">
  <a href="index.php" class="button button-tickets">Данные</a>
  <a href="#" class="button button-data">Билеты</a>
  <a href="../signout.php" class="button button-exit">Выход</a>
</div>

<div class="line-container">
  <div class="line"></div>
</div>

<?php 
// Запрос для получения билетов пользователя
$sql = "
SELECT 
    ticket.id_ticket,
    session.date,
    session.time,
    session.price,
    ticket.row,
    ticket.seats,
    film_session.name_film,
    film_session.duration,
    film_session.genres,
    film_session.director,
    film_session.cast,
    film_session.trailer,
    film_session.poster,
    film_session.fon,
    film_session.description,
    film_session.status,
    hall.name AS hall_name,
    hall.number_of_rows,
    hall.number_of_seats
FROM ticket
JOIN session ON ticket.id_session = session.id_session
JOIN film_session ON session.id_film_session = film_session.id_film_session
JOIN hall ON session.id_hall = hall.id_hall
WHERE ticket.id_user = ?
ORDER BY session.date, session.time
";

// Подготовка и выполнение запроса
$stmt = $connection->prepare($sql);
$stmt->bind_param("i", $id_user);
$stmt->execute();
$result = $stmt->get_result();

// Проверка наличия билетов
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        ?>
        <div class="container-move">
            <div class="movie-poster">
                <img src="../img/films/<?php echo $row['poster']; ?>" alt="Постер фильма">
                <div class="movie-info">
                    <p class="title-move"><?php echo htmlspecialchars($row['name_film']); ?></p>
                    <p class="duration">Длительность: <?php echo htmlspecialchars($row['duration']); ?> мин</p>
                    <p class="description"><?php echo htmlspecialchars($row['description']); ?></p>
                    <div class="showtimes">
                        <div class="notification">Время сеанса: <?php echo htmlspecialchars($row['date'] . ' ' . $row['time']); ?></div>
                        <div class="notification">Зал: <?php echo htmlspecialchars($row['hall_name']); ?></div>
                        <div class="notification">Ряд: <?php echo htmlspecialchars($row['row']); ?> <br> Место: <?php echo htmlspecialchars($row['seats']); ?></div>
                        <div class="notification">Цена: <?php echo htmlspecialchars($row['price']); ?> руб.</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="line"></div>
        <?php
    }
} else {
    echo "<p>У вас нет купленных билетов.</p>";
}

$stmt->close();
$connection->close();

require_once "../footer.php";
?>