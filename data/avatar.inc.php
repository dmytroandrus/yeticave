<?php
session_start();
$errors = [];
if (!$mysqli) {
    $errors['db_connect_error'] = 'Ошибка подключения к БД';
} else {
    if (isset($_SESSION['name'])) {
        $query = mysqli_query($mysqli, "SELECT img FROM users WHERE name = '$_SESSION[name]'");
        $user_avatar = mysqli_fetch_assoc($query);
        $user_avatar = $user_avatar['img'];
        $user_avatar = stristr($user_avatar, 'img');
    }
}
