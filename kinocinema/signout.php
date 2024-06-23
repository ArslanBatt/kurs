<?php
session_start();
session_destroy(); // Уничтожаем сессию
header("Location: /"); // Перенаправляем пользователя на главную страницу
exit();
?>