<?php
require_once "Connect.php";
session_start();

class Admin extends Connect
{
    public function createSession($hall, $film, $date, $time, $price)
    {
        if (empty($hall) || empty($film) || empty($date) || empty($time) || empty($price)) {
            return ["success" => false, "message" => "Заполните все поля!"];
        }

        $sql = "INSERT INTO session (id_hall, id_film_session, date, time, price)  
                VALUES ('$hall', '$film', '$date', '$time', '$price')";

        $result = mysqli_query($this->connection, $sql);

        if ($result) {
            return ["success" => true, "message" => "Сеанс успешно создан!"];
        } else {
            return ["success" => false, "message" => "Ошибка при добавлении сеанса: " . mysqli_error($this->connection)];
        }
    }

    public function createFilm($name, $duration, $genres, $director, $cast, $trailer, $description, $poster, $fon)
    {
        if (empty($name) || empty($duration) || empty($genres) || empty($director)) {
            return ["success" => false, "message" => "Заполните все обязательные поля!"];
        }

        $posterName = "";
        $fonName = "";

        if ($poster['size'] > 0) {
            $posterName = time() . "_" . basename($poster['name']);
            move_uploaded_file($poster['tmp_name'], "../img/films/" . $posterName);
        }

        if ($fon['size'] > 0) {
            $fonName = time() . "_" . basename($fon['name']);
            move_uploaded_file($fon['tmp_name'], "../img/films/" . $fonName);
        }

        $status = 0;

        $sql = "INSERT INTO film_session (`name_film`, `duration`, `genres`, `director`, `cast`, `trailer`, `description`, `poster`, `fon`, `status`)
                VALUES ('$name', '$duration', '$genres', '$director', '$cast', '$trailer', '$description', '$posterName', '$fonName', '$status')";

        $result = mysqli_query($this->connection, $sql);

        if ($result) {
            return ["success" => true, "message" => "Фильм успешно создан!"];
        } else {
            return ["success" => false, "message" => "Ошибка при добавлении фильма: " . mysqli_error($this->connection)];
        }
    }

    public function updateSession($sessionId, $hall, $film, $date, $time, $price)
    {
        if (empty($sessionId) || empty($hall) || empty($film) || empty($date) || empty($time) || empty($price)) {
            return ["success" => false, "message" => "Заполните все поля!"];
        }

        $sql = "UPDATE `session` SET  
                `id_hall` = '$hall', 
                `id_film_session` = '$film', 
                `date` = '$date', 
                `time` = '$time', 
                `price` = '$price' 
                WHERE `id_session` = '$sessionId'";

        $result = mysqli_query($this->connection, $sql);

        if ($result) {
            return ["success" => true, "message" => "Сеанс успешно обновлен!"];
        } else {
            return ["success" => false, "message" => "Ошибка при обновлении сеанса: " . mysqli_error($this->connection)];
        }
    }



    public function updateFilm($filmId, $name, $duration, $genres, $director, $cast, $trailer, $description, $poster, $fon, $status)
    {
        if (empty($filmId) || empty($name) || empty($duration) || empty($genres) || empty($director)) {
            return ["success" => false, "message" => "Заполните все обязательные поля!"];
        }

        $posterName = "";
        $fonName = "";

        if ($poster['size'] > 0) {
            $posterName = time() . "_" . basename($poster['name']);
            move_uploaded_file($poster['tmp_name'], "../img/films/" . $posterName);
        }

        if ($fon['size'] > 0) {
            $fonName = time() . "_" . basename($fon['name']);
            move_uploaded_file($fon['tmp_name'], "../img/films/" . $fonName);
        }

        $sql = "UPDATE film_session SET 
                name_film = '$name', 
                duration = '$duration', 
                genres = '$genres', 
                director = '$director', 
                cast = '$cast', 
                trailer = '$trailer', 
                description = '$description', 
                poster = IF('$posterName' != '', '$posterName', poster), 
                fon = IF('$fonName' != '', '$fonName', fon),
                status = '$status'
                WHERE id_film_session = '$filmId'";

        $result = mysqli_query($this->connection, $sql);

        if ($result) {
            return ["success" => true, "message" => "Фильм успешно обновлен!"];
        } else {
            return ["success" => false, "message" => "Ошибка при обновлении фильма: " . mysqli_error($this->connection)];
        }
    }
}

$admin = new Admin();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Проверяем, отправлена ли форма для создания сеанса
    if (isset($_POST['createSession'])) {
        $hall = $_POST['hall'];
        $film = $_POST['film'];
        $date = $_POST['date'];
        $time = $_POST['time'];
        $price = $_POST['price'];

        $result = $admin->createSession($hall, $film, $date, $time, $price);
        $_SESSION["message"] = $result["message"];

        if ($result["success"]) {
            header("Location: ../admin"); // Перенаправляем на ту же страницу после успешного создания
            exit;
        } else {
            // Обработка ошибки, например, вывод сообщения об ошибке
            echo "Ошибка: " . $result["message"];
        }
    }

    // Проверяем, отправлена ли форма для создания фильма
    if (isset($_POST['createFilm'])) {
        $name = $_POST['name_film'];
        $duration = $_POST['duration'];
        $genres = $_POST['genres'];
        $director = $_POST['director'];
        $cast = $_POST['cast'];
        $trailer = $_POST['trailer'];
        $description = $_POST['description'];
        $poster = $_FILES['poster'];
        $fon = $_FILES['fon'];

        $result = $admin->createFilm($name, $duration, $genres, $director, $cast, $trailer, $description, $poster, $fon);
        $_SESSION["message"] = $result["message"];

        if ($result["success"]) {
            header("Location: ../admin/film.php");
            exit;
        } else {
            echo "Ошибка: " . $result["message"];
        }
    }

    // Проверяем, отправлена ли форма для обновления сеанса
    if (isset($_POST['updateSession'])) {
        $sessionId = $_POST['sessionId'];
        $hall = $_POST['hall'];
        $film = $_POST['film'];
        $date = $_POST['date'];
        $time = $_POST['time'];
        $price = $_POST['price'];

        $result = $admin->updateSession($sessionId, $hall, $film, $date, $time, $price);
        $_SESSION["message"] = $result["message"];

        if ($result["success"]) {
            header("Location: ../admin");
            exit;
        } else {
            echo "Ошибка: " . $result["message"];
        }
    }

    if (isset($_POST['updateFilm'])) {
        $filmId = $_POST['filmId'];
        $name = $_POST['name_film'];
        $duration = $_POST['duration'];
        $genres = $_POST['genres'];
        $director = $_POST['director'];
        $cast = $_POST['cast'];
        $trailer = $_POST['trailer'];
        $description = $_POST['description'];
        $poster = $_FILES['poster'];
        $fon = $_FILES['fon'];
        $status = $_POST['status'];

        $result = $admin->updateFilm($filmId, $name, $duration, $genres, $director, $cast, $trailer, $description, $poster, $fon, $status);
        $_SESSION["message"] = $result["message"];

        if ($result["success"]) {
            header("Location: ../admin/film.php");
            exit;
        } else {
            echo "Ошибка: " . $result["message"];
        }
    }
}
