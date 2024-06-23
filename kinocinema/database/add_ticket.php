<?php
require_once "Connect.php"; // Подключение к БД и т.д.

// Создайте объект класса Connect
$db = new Connect();
$connection = $db->getConnection(); // Используйте метод getConnection()

if ($connection->connect_error) {
    die("Ошибка подключения: " . $connection->connect_error);
}

// Получение данных из запроса AJAX
$id_session = $_POST['id_session']; // Получите id_session из JavaScript
$row = $_POST['row'];
$seat = $_POST['seat'];
$id_user = $_POST['id_user']; // Получите id_user из JavaScript

// SQL-запрос для вставки данных в таблицу ticket
$sql = "INSERT INTO ticket (id_session, row, seats, id_user) 
        VALUES ('$id_session', '$row', '$seat', '$id_user')";

if ($connection->query($sql) === TRUE) {
    echo "Билет успешно добавлен";
} else {
    echo "Ошибка: " . $sql . "<br>" . $connection->error;
}

$connection->close();
?>
