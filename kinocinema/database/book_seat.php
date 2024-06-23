<?php
require_once "Connect.php";
session_start();

// Создайте объект класса Connect
$db = new Connect();
$connection = $db->getConnection(); // Используйте метод getConnection()

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data = json_decode(file_get_contents('php://input'), true);

  if (isset($data['sessionId'], $data['seats']) && isset($_SESSION['id_user'])) {
    $sessionId = $data['sessionId'];
    $seats = $data['seats'];
    $userId = $_SESSION['id_user'];

    foreach ($seats as $seat) {
      $row = $seat['row'];
      $seatNumber = $seat['seat'];

      // Исправленный SQL-запрос с использованием подготовленного оператора
      $sql = "INSERT INTO ticket (id_session, row, seats, id_user) VALUES (?, ?, ?, ?)";
      $stmt = $connection->prepare($sql);
      $stmt->bind_param('iisi', $sessionId, $row, $seatNumber, $userId);
      $stmt->execute();
    }

    echo json_encode(['success' => true]);
  } else {
    echo json_encode(['success' => false, 'message' => 'Недостаточно данных или пользователь не авторизован.']);
  }
} else {
  echo json_encode(['success' => false, 'message' => 'Неверный метод запроса.']);
}
?>
