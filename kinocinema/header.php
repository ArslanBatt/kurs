<?php 
require_once "database/Connect.php";

// Создайте объект класса Connect
$db = new Connect();
$connection = $db->getConnection(); // Используйте метод getConnection()


session_start();

if(isset($_SESSION["message"])){
  $mes = $_SESSION["message"];
  echo "<script>alert('$mes')</script>";
  unset($_SESSION["message"]);

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="/css/style.css">

</head>

<body>

  <header>
    <p class="logo">KinoCinema</p>
  </header>


  <nav>
  <ul>
    <li><a href="/index.php">Главная</a></li>
    <li><a href="/soon.php">Скоро выйдут</a></li>
    <li>
      <?php 
      if (isset($_SESSION['id_user'])) {
          if ($_SESSION['role_user'] == 'admin') {
              echo '<a href="/admin">' . $_SESSION['name'] . '</a>';
          } else {
              echo '<a href="/profile">' . $_SESSION['name'] . '</a>'; 
          }
          echo '<li><a href="/signout.php">Выход</a></li>';
      } else {
          echo '<a href="#" class="open-modal">Авторизация</a>'; 
      }
      ?>
    </li>
  </ul>
</nav>

    <!-- Регистрация -->
    <div class="modal">
      <div class="modal-header">
        <button class="modal-reg">Регистрация</button>
        <button class="modal-sign">Вход</button>
      </div>
      <hr class="modal__hr">
      <p class="modal__text">Укажите данные</p>
      <form class="modal__form" action="/database/User.php" method="POST">
      <input type="hidden" name="form_type" value="signup">
        <div class="modal__form-row">
          <img src="img/icon_sign/mail 1.png" alt="Иконка" class="modal__form-icon">
          <input type="email" placeholder="Ваша почта" class="modal__form-input" name="email">
        </div>
        <div class="modal__form-row">
          <img src="img/icon_sign/free-icon-profile-3106773 1.png" alt="Иконка" class="modal__form-icon">
          <input type="text" placeholder="Ваше имя" class="modal__form-input" name="name">
        </div>
        <div class="modal__form-row">
          <img src="img/icon_sign/free-icon-profile-3106773 1.png" alt="Иконка" class="modal__form-icon">
          <input type="text" placeholder="Ваша фамилия" class="modal__form-input" name="surname">
        </div>
        <div class="modal__form-row">
          <img src="img/icon_sign/free-icon-lock-2787245 1.png" alt="Иконка" class="modal__form-icon">
          <input type="password" placeholder="Ваш пароль" class="modal__form-input" name="pass">
        </div>
        <div class="modal__form-row modal__form-row--checkbox">
          <input type="checkbox" id="news" class="modal__form-checkbox">
          <label for="news" class="modal__form-label">Хочу получить информацию о новостях и акциях кинотеатра</label>
        </div>
        <div class="modal__form-row modal__form-row--checkbox">
          <input type="checkbox" id="agreement" class="modal__form-checkbox">
          <label for="agreement" class="modal__form-label">Принимаю условия <span
              class="open-agreement-button">Пользовательского соглашения</span></label>
        </div>
        <button type="submit" class="modal__form-button">Войти</button>
      </form>
    </div>

    <!-- Авторизация -->
    <div class="modal2">
      <div class="modal-header">
        <button class="modal2-reg">Регистрация</button>
        <button class="modal2-sign">Вход</button>
      </div>
      <hr>
      <p>Укажите данные</p>
      <form class="modal__form" action="/database/User.php" method="POST">
      <input type="hidden" name="form_type" value="signin">
        <div class="modal__form-row"> 
          <img src="img/icon_sign/mail 1.png" alt="Иконка">
          <input type="email" class="modal__form-input" placeholder="Ваша почта" name="email">
        </div>
        <div class="modal__form-row">
          <img src="img/icon_sign/free-icon-lock-2787245 1.png" alt="Иконка">
          <input type="password" class="modal__form-input" placeholder="Ваш пароль" name="pass">
        </div>
        <table>
          <tr>
            <td>
              <input type="checkbox" id="remember">
              <label for="remember">Запомни меня</label>
            </td>
            <td>
              <a href="#" class="forgot-password">Забыл пароль?</a>
            </td>
          </tr>
        </table>
        <button type="submit">Войти</button>
      </form>
    </div>

    <div class="overlay"></div>



  <!-- пользовательское соглашение -->

  <div class="agreement-modal-container">
    <div class="agreement-modal">
      <button class="close-button">×</button>
      <h2>Пользовательское соглашение сайта KinoCinema</h2>
      <article>
        <section>
          <h3>1. Общие положения</h3>
          <p>1.1. Настоящее Пользовательское соглашение (далее – Соглашение) регулирует отношения между владельцем сайта
            KinoCinema, расположенного по адресу [Адрес сайта] (далее – Сайт), и пользователем сети
            Интернет (далее – Пользователь), возникающие при использовании Сайта.</p>
          <p>1.2. Использование Сайта, в том числе просмотр размещенных на нем материалов, означает безоговорочное
            согласие Пользователя с настоящим Соглашением и принятие на себя обязательств по его соблюдению.</p>
          <p>1.3. Владелец Сайта оставляет за собой право изменять настоящее Соглашение в одностороннем порядке без
            предварительного уведомления Пользователя. Действующая редакция Соглашения размещается на Сайте в модальном окне, доступном по ссылке  [Адрес страницы с Соглашением].</p>
        </section>
        <section>
          <h3>2. Предмет соглашения</h3>
          <p>2.1. Сайт предоставляет Пользователю доступ к информации о кинотеатре KinoCinema, расписанию сеансов, стоимости
            билетов, а также возможность онлайн-бронирования и покупки билетов.</p>
          <p>2.2. Настоящее Соглашение распространяется на все сервисы Сайта, как существующие на данный момент, так и
            запускаемые в будущем.</p>
        </section>
        <section>
          <h3>3. Права и обязанности сторон</h3>
          <p>3.1. Пользователь имеет право:</p>
          <ul>
            <li>3.1.1. Пользоваться всеми функциональными возможностями Сайта в соответствии с его назначением.</li>
            <li>3.1.2. Получать информацию о новостях и акциях кинотеатра KinoCinema.</li>
            <li>3.1.3. Обращаться в службу поддержки Сайта по вопросам, связанным с его работой.</li>
          </ul>
          <p>3.2. Пользователь обязуется:</p>
          <ul>
            <li>3.2.1. Предоставлять достоверную и актуальную информацию при бронировании и покупке билетов.</li>
            <li>3.2.2. Не использовать Сайт в незаконных целях, в том числе для распространения информации, нарушающей
              права третьих лиц.</li>
            <li>3.2.3. Не предпринимать действий, которые могут нарушить нормальную работу Сайта.</li>
            <li>3.2.4. Не использовать автоматизированные скрипты для сбора информации с Сайта.</li>
            <li>3.2.5. Соблюдать авторские и иные права интеллектуальной собственности на материалы, размещенные на
              Сайте.</li>
          </ul>
          <p>3.3. Администрация сайта имеет право:</p>
          <ul>
            <li>3.3.1. Вносить изменения в работу Сайта, добавлять новые сервисы и функции.</li>
            <li>3.3.2. Приостанавливать работу Сайта для проведения технических работ.</li>
            <li>3.3.3. Блокировать доступ к Сайту Пользователей, нарушающих настоящее Соглашение.</li>
          </ul>
        </section>
        <section>
          <h3>4. Ответственность сторон</h3>
          <p>4.1. Администрация Сайта не несет ответственности за:</p>
          <ul>
            <li>4.1.1. Задержки, сбои, неточности в работе Сайта, вызванные техническими неполадками, действиями третьих
              лиц или другими причинами, не зависящими от Администрации Сайта.</li>
            <li>4.1.2. Убытки, возникшие у Пользователя в результате использования или невозможности использования
              Сайта.</li>
            <li>4.1.3. Несоответствие услуг, предоставляемых кинотеатром KinoCinema, ожиданиям Пользователя.</li>
          </ul>
          <p>4.2. Пользователь несет ответственность за:</p>
          <ul>
            <li>4.2.1. Соблюдение условий настоящего Соглашения.</li>
            <li>4.2.2. Достоверность информации, предоставляемой при бронировании и покупке билетов.</li>
            <li>4.2.3. Любые противоправные действия, совершенные с использованием Сайта.</li>
          </ul>
        </section>
        <section>
          <h3>5. Разрешение споров</h3>
          <p>5.1. Все споры, возникающие в связи с исполнением настоящего Соглашения, решаются путем переговоров.</p>
          <p>5.2. В случае невозможности урегулирования споров путем переговоров, спор передается на рассмотрение в суд
            по месту нахождения Администрации Сайта.</p>
        </section>
        <section>
          <h3>6. Заключительные положения</h3>
          <p>6.1. Настоящее Соглашение вступает в силу с момента начала использования Сайта Пользователем и действует
            бессрочно.</p>
          <p>6.2. Во всем остальном, что не предусмотрено настоящим Соглашением, стороны руководствуются действующим
            законодательством Российской Федерации.</p>
        </section>
        <section>
          <h3>7. Контактная информация</h3>
          <p>Адрес: культура д. 13</p>
          <p>Email: kinocinema@gmail.com</p>
          <p>Телефон: 8-800-555-35-35</p>
          <p>_Дата последнего обновления:  <?php echo date("d.m.Y"); ?>_</p>
        </section>
      </article>
    </div>
  </div>

  <script src="js/modal.js"></script>