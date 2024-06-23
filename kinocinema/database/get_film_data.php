<?php
require_once "Connect.php";

$db = new Connect();
$connection = $db->getConnection();

$filmId = isset($_GET['id']) ? intval($_GET['id']) : 0;

$filmData = array();
if ($filmId > 0) {
    $sql = "SELECT * FROM film_session WHERE id_film_session = ?";
    $stmt = mysqli_prepare($connection, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $filmId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            $filmData = $row;
        }

        mysqli_stmt_close($stmt);
    } else {
        die("Ошибка подготовки запроса: " . mysqli_error($connection));
    }
}

echo json_encode(array('film' => $filmData));
?>
