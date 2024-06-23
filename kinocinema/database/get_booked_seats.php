<?php
require_once "Connect.php";
session_start();

// Создайте объект класса Connect
$db = new Connect();
$connection = $db->getConnection(); // Используйте метод getConnection()

if (isset($_GET['sessionId'])) {
  $sessionId = $_GET['sessionId'];
  $sql = "SELECT row, seats FROM ticket WHERE id_session = ?";
  $stmt = $connection->prepare($sql);
  $stmt->bind_param('i', $sessionId);
  $stmt->execute();
  $result = $stmt->get_result();
  $bookedSeats = [];
  
  while ($row = $result->fetch_assoc()) {
    $seatIndex = ($row['row'] - 1) * 16 + $row['seats'];
    $bookedSeats[] = $seatIndex;
  }

  echo json_encode(['bookedSeats' => $bookedSeats]);
} else {
  echo json_encode(['bookedSeats' => []]);
}
?>
