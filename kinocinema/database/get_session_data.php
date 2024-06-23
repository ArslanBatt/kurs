<?php
require_once "Connect.php"; 

$db = new Connect();
$connection = $db->getConnection(); 

$sessionId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Получение данных о сеансе
$sessionData = array();
if ($sessionId > 0) {
    $sql = "SELECT * FROM session WHERE id_session = ?";
    $stmt = mysqli_prepare($connection, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $sessionId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            $sessionData = $row;
        }

        mysqli_stmt_close($stmt);
    } else {
        die("Ошибка подготовки запроса: " . mysqli_error($connection));
    }
}

// Получение данных о залах
$hallsData = array();
$sqlHalls = "SELECT id_hall, name FROM hall";
$resultHalls = mysqli_query($connection, $sqlHalls);
if ($resultHalls) {
    while ($row = mysqli_fetch_assoc($resultHalls)) {
        $hallsData[] = $row;
    }
}

// Получение данных о фильмах
$filmsData = array();
$sqlFilms = "SELECT id_film_session, name_film FROM film_session";
$resultFilms = mysqli_query($connection, $sqlFilms);
if ($resultFilms) {
    while ($row = mysqli_fetch_assoc($resultFilms)) {
        $filmsData[] = $row;
    }
}

// Объединение всех данных в один массив
$responseData = array(
    'session' => $sessionData,
    'halls' => $hallsData,
    'films' => $filmsData
);

echo json_encode($responseData); 
?>