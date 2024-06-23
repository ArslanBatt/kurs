<?php
require_once "../header.php";
session_start();


if ($_SESSION['role_user'] != 'admin') {
  $_SESSION["message"] = "Доступ запрещён";
  header("../");
}

// Запрос для получения данных фильмов
$sql = "SELECT * FROM film_session";
$result = mysqli_query($connection, $sql);

$status = ['Скоро', 'В прокате']
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Пользователь</title>
  <link rel="stylesheet" href="../css/admin.css">
</head>

<body>
  <div class="button-container">
    <a href="index.php" class="button button-tickets">Сеансы</a>
    <a href="#" class="button button-data">Фильмы</a>
    <a href="../signout.php" class="button button-exit">Выход</a>
  </div>

  <div class="line-container">
    <div class="line"></div>
  </div>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Постер</th>
        <th>Фон</th>
        <th>Название</th>
        <th>Продолжительность</th>
        <th>Жанры</th>
        <th>Режиссер</th>
        <th>Актеры</th>
        <th>Трейлер</th>
        <th>Описание</th>
        <th>Статус</th>
        <th>Действия</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($film = mysqli_fetch_assoc($result)) : ?>
        <tr>
          <td><?= $film['id_film_session'] ?></td>
          <td><img src="../img/films/<?= $film['poster'] ?>" alt="<?= $film['name_film'] ?>" width="50"></td>
          <td><img src="../img/films/<?= $film['fon'] ?>" alt="<?= $film['name_film'] ?>" width="50"></td>
          <td><?= $film['name_film'] ?></td>
          <td><?= $film['duration'] ?></td>
          <td><?= $film['genres'] ?></td>
          <td><?= $film['director'] ?></td>
          <td><?= $film['cast'] ?></td>
          <td><?= $film['trailer'] ?></td>
          <td>
            <span>
              <?= mb_substr($film['description'], 0, 50, 'UTF-8') ?>
              <span id="dots_<?= $film['id_film_session'] ?>">...</span>
              <span id="more_<?= $film['id_film_session'] ?>" style="display:none;">
                <?= mb_substr($film['description'], 50, null, 'UTF-8') ?>
              </span>
            </span>
            <button onclick="toggleDescription(<?= $film['id_film_session'] ?>)" id="btn_<?= $film['id_film_session'] ?>">Развернуть</button>
          </td>
          <td>
            <?= $status[$film['status']]?> 
          </td>
          <td>
          <a href="#" onclick="openEditFilmModal(<?= $film['id_film_session'] ?>)">Редактировать</a>
            <a href='#' onclick="confirmDelete(<?= $film['id_film_session'] ?>)">Удалить</a>
          </td>
        </tr>
      <?php endwhile; ?>
      <?php if (mysqli_num_rows($result) == 0): ?>
        <tr>
          <td colspan='12'>Нет данных о филмах.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>

  <!-- Модальное окно создания фильма -->
  <div class="modal-overlay" id="createFilmModal">
    <div class="modal-container">
      <span class="close-button" onclick="document.getElementById('createFilmModal').style.display='none'">&times;</span>
      <h2>Создание нового фильма</h2>
      <form action="../database/Admin.php" method="post" enctype="multipart/form-data">
        <div class="modal-field">
          <label for="name_film">Название:</label>
          <input type="text" id="name_film" name="name_film" required>
        </div>
        <div class="modal-field">
          <label for="duration">Продолжительность:</label>
          <input type="number" id="duration" name="duration" required>
        </div>
        <div class="modal-field">
          <label for="genres">Жанры:</label>
          <input type="text" id="genres" name="genres" required>
        </div>
        <div class="modal-field">
          <label for="director">Режиссер:</label>
          <input type="text" id="director" name="director" required>
        </div>
        <div class="modal-field">
          <label for="cast" style="display: flex;">Актеры:</label>
          <textarea id="cast" name="cast"></textarea>
        </div>
        <div class="modal-field">
          <label for="trailer">Трейлер (ссылка):</label>
          <input type="text" id="trailer" name="trailer">
        </div>
        <div class="modal-field">
          <label for="description" style="display: flex;">Описание:</label>
          <textarea id="description" name="description"></textarea>
        </div>
        <div class="modal-field">
          <label for="poster">Постер:</label>
          <input type="file" id="poster" name="poster" accept="image/*">
        </div>
        <div class="modal-field">
          <label for="fon">Фон:</label>
          <input type="file" id="fon" name="fon" accept="image/*">
        </div>
        <button type="submit" name="createFilm" class="modal-button">Создать</button>
      </form>
    </div>
  </div>



  <!-- Модальное окно редактирования фильма -->
<div class="modal-overlay edit_film">
  <div class="modal-container">
    <span class="close-button" onclick="closeEditFilmModal()">&times;</span>
    <h2>Редактирование фильма</h2>
    <form action="../database/Admin.php" method="post" enctype="multipart/form-data">
      <input type="hidden" id="editFilmId" name="filmId">
      <div class="modal-field">
        <label for="edit_name_film">Название:</label>
        <input type="text" id="edit_name_film" name="name_film" required>
      </div>
      <div class="modal-field">
        <label for="edit_duration">Продолжительность:</label>
        <input type="number" id="edit_duration" name="duration" required>
      </div>
      <div class="modal-field">
        <label for="edit_genres">Жанры:</label>
        <input type="text" id="edit_genres" name="genres" required>
      </div>
      <div class="modal-field">
        <label for="edit_director">Режиссер:</label>
        <input type="text" id="edit_director" name="director" required>
      </div>
      <div class="modal-field">
        <label for="edit_cast" style="display: flex;">Актеры:</label>
        <textarea id="edit_cast" name="cast"></textarea>
      </div>
      <div class="modal-field">
        <label for="edit_trailer">Трейлер (ссылка):</label>
        <input type="text" id="edit_trailer" name="trailer">
      </div>
      <div class="modal-field">
        <label for="edit_description" style="display: flex;">Описание:</label>
        <textarea id="edit_description" name="description"></textarea>
      </div>
      <div class="modal-field">
        <label for="edit_poster">Постер:</label>
        <input type="file" id="edit_poster" name="poster" accept="image/*">
      </div>
      <div class="modal-field">
        <label for="edit_fon">Фон:</label>
        <input type="file" id="edit_fon" name="fon" accept="image/*">
      </div>
      <div class="modal-field">
        <label for="edit_status" style="display: flex;">Статус:</label>
        <select id="edit_status" name="status">
          <option value="0">Скоро</option>
          <option value="1">В прокате</option>
        </select>
      </div>
      <button type="submit" name="updateFilm" class="modal-button">Сохранить изменения</button>
    </form>
  </div>
</div>




  <a href="#" class="add-button"></a>

  <script src="../js/descript.js"></script>
  <script src="../js/modal-create-film.js"></script>
  <script src="../js/modal-edit-film.js"></script>
  <script src="../js/delete-film.js"></script>
</body>

</html>

<?php
require_once "../footer.php";
?>
