<?php
require_once "Connect.php";
session_start();


class User extends Connect
{

    public function signup($email, $name, $surname, $pass)
    {
        if (empty($email) || empty($name) || empty($surname) || empty($pass)) {
            return ["success" => false, "message" => "Заполните все поля!"];
        }

        $sql = "INSERT INTO users (email, name, surname, pass) VALUES ('$email','$name','$surname','$pass')";
        $result = mysqli_query($this->connection, $sql);

        if ($result) {
            return ["success" => true, "message" => "Успех!"];
        } else {
            return ["success" => false, "message" => mysqli_error($this->connection)];
        }
    }

    public function signin($email, $pass)
    {
        if (empty($email) || empty($pass)) {
            return ["success" => false, "message" => "Заполните все поля!"];
        }

        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($this->connection, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);

            if ($pass === $user['pass']) {
                // Сохраняем данные пользователя в сессии
                $_SESSION['id_user'] = $user['id_user'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['role_user'] = $user['role_user'];

                // Перенаправление в зависимости от роли
                if ($user['role_user'] == 'admin') {
                    return ["success" => true, "message" => "Вход выполнен!", "redirect" => "/admin"];
                } else {
                    return ["success" => true, "message" => "Вход выполнен!", "redirect" => "/profile"];
                }
            } else {
                return ["success" => false, "message" => "Неверный пароль."];
            }
        } else {
            return ["success" => false, "message" => "Пользователь с таким email не найден."];
        }
    }



    public function addComment($id_user, $id_film_session, $commentText)
{
    if (empty($commentText)) {
        return ["success" => false, "message" => "Комментарий не может быть пустым!"];
    }

    $commentText = mysqli_real_escape_string($this->connection, $commentText);
    $sql = "INSERT INTO comm (id_user, id_film_session, text) VALUES ('$id_user', '$id_film_session', '$commentText')";
    $result = mysqli_query($this->connection, $sql);

    if ($result) {
        return ["success" => true, "message" => "Комментарий успешно добавлен"];
    } else {
        return ["success" => false, "message" => mysqli_error($this->connection)];
    }
}


public function updateProfile($userId, $name, $surname, $email, $password)
{
    // Проверка наличия соединения с базой данных
    if (!$this->connection) {
        return ["success" => false, "message" => "Ошибка соединения с базой данных"];
    }

    // Проверка на пустые поля
    if (empty($name) || empty($surname) || empty($email) || empty($password)) {
        return ["success" => false, "message" => "Заполните все поля"];
    }

    // Проверка уникальности email
    $sql = "SELECT * FROM users WHERE email = ? AND id_user != ?";
    $stmt = mysqli_prepare($this->connection, $sql);
    mysqli_stmt_bind_param($stmt, "si", $email, $userId);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        return ["success" => false, "message" => "Пользователь с такой почтой уже существует"];
    }

    // Обновление данных пользователя
    $sql = "UPDATE users SET name = ?, surname = ?, email = ?, pass = ? WHERE id_user = ?";
    $stmt = mysqli_prepare($this->connection, $sql);
    mysqli_stmt_bind_param($stmt, "ssssi", $name, $surname, $email, $password, $userId);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        return ["success" => true, "message" => "Данные успешно обновлены"];
    } else {
        return ["success" => false, "message" => "Ошибка при обновлении данных: " . mysqli_error($this->connection)];
    }
}

}

$user = new User();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['form_type']) && $_POST['form_type'] == 'signin') {
        $email = $_POST["email"] ?? "";
        $pass = $_POST["pass"] ?? "";

        $result = $user->signin($email, $pass);
        $_SESSION["message"] = $result["message"];

        if ($result["success"]) {
            header("Location: " . $result["redirect"]); // Перенаправляем по адресу из $result
        } else {
            header("Location: /"); // Или на страницу с формой входа
        }

    } else { // Если не форма входа, значит форма регистрации
        $email = $_POST["email"] ?? "";
        $name = $_POST["name"] ?? "";
        $surname = $_POST["surname"] ?? "";
        $pass = $_POST["pass"] ?? "";

        $result = $user->signup($email, $name, $surname, $pass);
        $_SESSION["message"] = $result["message"];

        if ($result["success"]) {
            header("Location: /"); // Или на нужную страницу после регистрации
        } else {
            header("Location: /"); // Или на страницу с формой регистрации
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_comment']) && $_POST['add_comment'] == 'true') {
        $commentText = $_POST["commentText"] ?? "";
        $id_film_session = $_POST["id_film_session"] ?? ""; // Получаем id фильма из формы

        if (!empty($commentText) && $id_film_session) {
            $id_user = $_SESSION['id_user'];

            $result = $user->addComment($id_user, $id_film_session, $commentText);
            $_SESSION["message"] = $result["message"];

            if ($result["success"]) {
                header("Location: /films.php?id=$id_film_session"); // Перенаправляем на страницу фильма
                exit; // Важно завершить выполнение скрипта после перенаправления
            } else {
                header("Location: /"); // Или на страницу с формой добавления комментария
                exit; // Важно завершить выполнение скрипта после перенаправления
            }
        }
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['form_type']) && $_POST['form_type'] == 'profile_update') {
        $userId = $_SESSION['id_user'];
        $name = $_POST['name'] ?? "";
        $surname = $_POST['surname'] ?? "";
        $email = $_POST['email'] ?? "";
        $password = $_POST['password'] ?? "";

        $result = $user->updateProfile($userId, $name, $surname, $email, $password);
        $_SESSION["message"] = $result["message"];

        if ($result["success"]) {
            header("Location: ../profile ");
            exit;
        } else {
            header("Location: ../profile ");
            exit;
        }
    }
}

?>