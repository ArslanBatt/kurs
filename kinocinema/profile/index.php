<?php
require_once "../header.php";

$sql = "SELECT * FROM users WHERE id_user =" . $_SESSION['id_user'];
$result = mysqli_query($connection, $sql);
$user = mysqli_fetch_assoc($result);

?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Пользователь</title>
  <link rel="stylesheet" href="/css/profile.css">
</head>

<div class="button-container">
  <a href="#" class="button button-data">Данные</a>
  <a href="tickets.php" class="button button-tickets">Билеты</a>
  <a href="../signout.php" class="button button-exit">Выход</a>
</div>

<div class="line-container">
  <div class="line"></div>
</div>


<div class="container">
  <form action="../database/User.php" method="post">
    <input type="hidden" name="form_type" value="profile_update">
    <div class="input-group">
      <label for="name">Имя:</label>
      <input type="text" id="name" name="name" value='<?= htmlspecialchars($user["name"]) ?>'>
    </div>

    <div class="input-group">
      <label for="surname">Фамилия:</label>
      <input type="text" id="surname" name="surname" value='<?= htmlspecialchars($user["surname"]) ?>'>
    </div>

    <div class="input-group">
      <label for="email">Почта:</label>
      <input type="email" id="email" name="email" value='<?= htmlspecialchars($user["email"]) ?>'>
    </div>

    <div class="input-group password-container">
      <label for="password">Пароль:</label>
      <div class="password-field"  style="display: flex;" >
        <input type="password" id="password" name="password" value='<?= htmlspecialchars($user["pass"]) ?>'>
        <span class="toggle-password" onclick="togglePasswordVisibility(this)">
          <img src="../img/icon/close.png" alt="">
        </span>
      </div>
    </div>

    <button type="submit" class="button" style="font-size: 20px;">Сохранить изменения</button>
  </form>
</div>

<script src="../js/password.js"></script>

<?php
require_once "../footer.php"
?>
