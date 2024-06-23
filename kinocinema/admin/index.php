<?php
require_once "../header.php";
session_start();
if ($_SESSION['role_user'] != 'admin') {
  $_SESSION["message"] = "Доступ запрещён";
  header("Location: ../");
}

$sql = "SELECT session.id_session, hall.name AS hall_name, session.date, session.time, session.price, film_session.name_film 
        FROM session
        JOIN hall ON session.id_hall = hall.id_hall
        JOIN film_session ON session.id_film_session = film_session.id_film_session ORDER BY session.id_session ASC ";

$result = mysqli_query($connection, $sql);


// Запрос для получения залов
$sqlHalls = "SELECT id_hall, name FROM hall";
$resultHalls = mysqli_query($connection, $sqlHalls);

// Запрос для получения фильмов 
$sqlFilms = "SELECT id_film_session, name_film FROM film_session WHERE status = '1'";
$resultFilms = mysqli_query($connection, $sqlFilms);

?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Администратор</title>
  <link rel="stylesheet" href="../css/admin_film.css">




</head>

<div class="button-container">
  <a href="#" class="button button-data">Сеансы</a>
  <a href="film.php" class="button button-tickets">Фильмы</a>
  <a href="../signout.php" class="button button-exit">Выход</a>
</div>

<div class="line-container">
  <div class="line"></div>
</div>

<div class="table-container">
  <table>
    <thead>
      <tr>
        <th>ID Сеанса</th>
        <th>Зал</th>
        <th>Дата</th>
        <th>Время</th>
        <th>Цена</th>
        <th>Фильм</th>
        <th>Действия</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
          <td><?= $row['id_session'] ?></td>
          <td><?= $row['hall_name'] ?></td>
          <td><?= $row['date'] ?></td>
          <td><?= $row['time'] ?></td>
          <td><?= $row['price'] ?> ₽</td>
          <td><?= $row['name_film'] ?></td>
          <td>
            <a href="#" onclick="openEditModal(<?= $row['id_session'] ?>)">Редактировать</a>
            <a href="#" onclick="confirmDelete(<?= $row['id_session'] ?>)">Удалить</a>
          </td>
        </tr>
      <?php endwhile; ?>
      <?php if (mysqli_num_rows($result) == 0): ?>
        <tr>
          <td colspan='7'>Нет данных о сеансах.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<a href="#" class="add-button"></a>


<!-- Модальное окно создания сеанса -->
<div class="creat_session modal-overlay">
  <div class="modal-container">
    <span class="close-button" onclick="closeModal()">&times;</span>
    <h2>Создание нового сеанса</h2>
    <form action="../database/Admin.php" method="post">
      <div class="modal-field">
        <label for="hall">Зал:</label>
        <select id="hall" name="hall">
          <option value="">Выберите зал</option>
          <?php while ($row = mysqli_fetch_assoc($resultHalls)): ?>
            <option value="<?= $row['id_hall'] ?>"><?= $row['name'] ?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="modal-field">
        <label for="film">Фильм:</label>
        <select id="film" name="film">
          <option value="">Выберите фильм</option>
          <?php while ($row = mysqli_fetch_assoc($resultFilms)): ?>
            <option value="<?= $row['id_film_session'] ?>"><?= $row['name_film'] ?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="modal-field">
        <label for="date">Дата:</label>
        <input type="date" id="date" name="date" required>
      </div>
      <div class="modal-field">
        <label for="time">Время:</label>
        <input type="time" id="time" name="time" required>
      </div>
      <div class="modal-field">
        <label for="price">Цена:</label>
        <input type="number" id="price" name="price" min="0" required>
      </div>
      <button type="submit" name="createSession" class="modal-button">Создать</button>
    </form>
  </div>
</div>



<!-- Модальное окно редактирования сеанса -->
<div class="edit_session modal-overlay">
  <div class="modal-container">
    <span class="close-button" onclick="closeEditModal()">&times;</span>
    <h2>Редактирование сеанса</h2>
    <form action="../database/Admin.php" method="post">
      <input type="hidden" id="editSessionId" name="sessionId">
      <div class="modal-field">
        <label for="editHall">Зал:</label>
        <select id="editHall" name="hall">
        </select>
      </div>
      <div class="modal-field">
        <label for="editFilm">Фильм:</label>
        <select id="editFilm" name="film">
        </select>
      </div>
      <div class="modal-field">
        <label for="editDate">Дата:</label>
        <input type="date" id="editDate" name="date" required>
      </div>
      <div class="modal-field">
        <label for="editTime">Время:</label>
        <input type="time" id="editTime" name="time" required>
      </div>
      <div class="modal-field">
        <label for="editPrice">Цена:</label>
        <input type="number" id="editPrice" name="price" min="0" required>
      </div>
      <button type="submit" name="updateSession" class="modal-button">Сохранить</button>
    </form>
  </div>
</div>




<script src="../js/delete-session.js"></script>
<script src="../js/modal-edit-session.js"></script>
<script src="../js/modal-create-session.js"></script>

<?php
require_once "../footer.php";
?>