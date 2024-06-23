<?php 

require_once "Connect.php";  
session_start();  

// Создайте объект класса Connect 
$db = new Connect(); 
$connection = $db->getConnection(); // Используйте метод getConnection() 

// Проверка, был ли отправлен запрос DELETE
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') { 
  // Получение ID сеанса из параметра запроса
  $sessionId = $_GET['id'];

  // Подготовка и выполнение SQL-запроса на удаление
  $sql = "DELETE FROM session WHERE id_session = '$sessionId'";

  if (mysqli_query($connection, $sql)) {
    // Успешное удаление
    http_response_code(200); // Устанавливаем код ответа 200 (OK)
    echo "Сеанс успешно удален.";
  } else {
    // Ошибка при удалении
    http_response_code(500); // Устанавливаем код ответа 500 (Internal Server Error)
    echo "Ошибка при удалении сеанса: " . mysqli_error($connection);
  }

  mysqli_close($connection);
} else {
  // Если запрос не DELETE, возвращаем ошибку 405 (Method Not Allowed)
  http_response_code(405); 
  echo "Метод запроса не разрешен.";
}
?>