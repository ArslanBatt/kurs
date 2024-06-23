<?php
require_once "header.php";

$filmId = $_GET['id'];
if (isset($_GET['id'])) {
  $filmId = $_GET['id'];
  $sql = "SELECT * FROM film_session WHERE id_film_session = $filmId";
  $result = mysqli_query($connection, $sql);
  $film = mysqli_fetch_assoc($result);

  if (!$film) {
    die("Фильм не найден.");
  }
} else {
  die("ID фильма не передан.");
}

$sessionsSql = "SELECT id_session, date, time, hall.name as hall FROM session, hall WHERE session.id_hall = hall.id_hall AND id_film_session = $filmId ORDER BY date, time";
$sessionsResult = mysqli_query($connection, $sessionsSql);

$sessions = [];
while ($session = mysqli_fetch_assoc($sessionsResult)) {
  $date = $session['date'];
  if (!isset($sessions[$date])) {
    $sessions[$date] = [];
  }
  $sessions[$date][] = $session;
}

?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $film['name_film'] ?></title>
  <link rel="stylesheet" href="css/films.css">
</head>

<style>
  .movie-card {
    height: auto;
    padding: 20px;
    box-sizing: border-box;
    display: flex;
    flex-direction: column;
    align-items: center;
    background-image:
      linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)),
      url('img/films/<?= $film['fon'] ?>');
    background-size: cover;
    background-position: center;
  }

  .session-date {
    margin-top: 20px;
    /* добавляем небольшой отступ между датами */
    border-top: 1px solid #ccc;
    /* добавляем разделительную линию между датами */
    padding-top: 20px;
    /* увеличиваем отступ для видимости разделителя */
  }
</style>

<main>
  <div class="movie-card">
    <div class="movie-content">
      <div class="movie-poster">
        <img src="img/films/<?= $film['poster'] ?>" alt="Постер к фильму">
      </div>
      <div class="movie-info">
        <h1 id="movieTitle"><?= $film['name_film'] ?></h1>
        <p>Продолжительность: <?= $film['duration'] ?> мин. / Жанры: <?= $film['genres'] ?></p>
        <button class="watch-trailer" id="myBtn">Смотреть трейлер</button>
        <p class="director">Режиссер: <span><?= $film['director'] ?></span></p>
        <p class="cast">В ролях: <span><?= $film['cast'] ?></span></p>
        <p class="description">Описание: <span><?= $film['description'] ?></span></p>
      </div>
    </div>
  </div>

  <div class="main-container">
    <div class="container">
      <h2>Сеансы</h2>
      <div class="session-group">
        <?php if (!empty($sessions)) { ?>
          <?php foreach ($sessions as $date => $sessionsOnDate) { ?>
            <div class="session-date">
              <h3><?= $date ?></h3>
              <?php foreach ($sessionsOnDate as $session) { ?>
                <div class="showtimes">
                  <div class="time" data-time="<?= $session['time'] ?>" data-hall="<?= $session['hall'] ?>" data-session-id="<?= $session['id_session'] ?>"></div>
                </div>
              <?php } ?>
            </div>
          <?php } ?>
        <?php } else { ?>
          <p>Нет доступных сеансов для этого фильма.</p>
        <?php } ?>
      </div>

      <div class="comments">
        <h2>Комментарии</h2>

        <?php if (isset($_SESSION['id_user'])) { ?>
          <div class="user-comment">
            <span class="user-name">
              <form class="comm" action="database/User.php" method="post">
                <input type="hidden" name="add_comment" value="true">
                <input type="hidden" name="id_film_session" value="<?= $filmId ?>">
                <input type="text" class="modal__form-input_comm" placeholder="Оставить комментарий" name="commentText">
                <input class="modal__form-btn" type="submit" value="Отправить">
              </form>
          </div>
        <?php } ?>

        <div class="comments-list">
          <?php
          // Получаем комментарии к текущему фильму
          $commentsSql = "SELECT * FROM comm, users WHERE comm.id_user = users.id_user AND id_film_session = $filmId";
          $commentsResult = mysqli_query($connection, $commentsSql);

          if (mysqli_num_rows($commentsResult) > 0) {
            while ($comment = mysqli_fetch_assoc($commentsResult)) {
              echo "<div class='comment'>";
              echo "<span class='comment-author'>Имя пользователя:{$comment['name']}</span> <p class='comment-text'>{$comment['text']}</p>";
              echo "</div>";
            }
          } else {
            echo "<p class='no-comments'>Пока здесь нет комментариев.</p>";
          }
          ?>
        </div>
      </div>
    </div>
  </div>

  <button id="back-to-top-btn">Наверх</button>

  <div id="myModal" class="modal-trailer">
    <div class="modal-content-trailer">
      <span class="close-trailer">&times;</span>
      <h2 id="modalMovieTitle"></h2>
      <div class="video-container">
        <iframe id="trailerIframe" width="100%" src="<?= $film['trailer'] ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
        </iframe>
      </div>
    </div>
  </div>

  <div id="ticketModal" class="modal_halls">
    <div class="modal_hall">
      <div class="modal-content-hall">
        <span class="close">&times;</span>
        <h2 id="modalFilmTitle">Название фильма</h2>
        <p id="modalSessionInfo">Дата _ Зал</p>
        <div class="screen"></div>
        <div class="seats">
          <?php
          $seatsPerRow = 16;
          $numRows = 6;
          function generateSeats($numRows, $seatsPerRow)
          {
            for ($row = 1; $row <= $numRows; $row++) {
              echo "<div class='seat-row'>";
              for ($seatNumber = 1; $seatNumber <= $seatsPerRow; $seatNumber++) {
                $seatIndex = ($row - 1) * $seatsPerRow + $seatNumber;
                echo "<div class='seat seat-available' data-row='$row' data-seat='$seatNumber' data-seat-index='$seatIndex'>";
                echo "<span class='seat-number'>$seatNumber</span>";
                echo "<span class='row-left'>$row</span>";
                echo "<span class='row-right'>$row</span>";
                echo "</div>";
              }
              echo "</div>";
            }
          }
          generateSeats($numRows, $seatsPerRow);
          ?>
        </div>
        <button class="buy-button">Купить</button>
      </div>
    </div>
  </div>
</main>
<script src="js/modal_hall.js" async defer></script>
<script src="js/days_film.js" async defer></script>
<script src="js/trailer.js" async defer></script>
<script src="js/up.js" async defer></script>

<?php
require_once "footer.php";
?>