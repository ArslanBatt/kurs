<?php 

require_once "Connect.php";  
session_start();  

// Создайте объект класса Connect 
$db = new Connect(); 
$connection = $db->getConnection(); // Используйте метод getConnection() 

// Проверка, был ли отправлен запрос DELETE
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') { 
  // Получение ID фильма из параметра запроса
  $filmId = $_GET['id'];

  // Подготовка и выполнение SQL-запроса на удаление
  $sql = "DELETE FROM film_session WHERE id_film_session = '$filmId'";

  if (mysqli_query($connection, $sql)) {
    // Успешное удаление
    http_response_code(200); // Устанавливаем код ответа 200 (OK)
    echo "Фильм успешно удален.";
  } else {
    // Ошибка при удалении
    http_response_code(500); // Устанавливаем код ответа 500 (Internal Server Error)
    echo "Ошибка при удалении фильма: " . mysqli_error($connection);
 
  }
}