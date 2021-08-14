<?php
require_once '../vendor/autoload.php';

require_once '../core/functions.php';
require_once '../core/db_connect.php';
require_once '../data/avatar.inc.php';
include_once '../data/categories.inc.php';

// id лота
if (count($_GET) && isset($_GET['id'])) {
    $lot_id = (int)htmlspecialchars($_GET['id']);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (count($_POST) && isset($_POST['cost'])) {
        $cost = (int)htmlspecialchars($_POST['cost']);
    }
    // достаем максимальную ставку из базы
    if ($mysqli) {
        $max_cost = mysqli_query($mysqli, "SELECT value FROM stakes WHERE lot_id = '$lot_id' ORDER BY value DESC");
        $max_cost  = mysqli_fetch_assoc($max_cost);
    }
    // var_dump($max_cost);
    // die;
    if (!$mysqli) {
        $errors['db_connect_error'] = 'Ошибка подключения к БД';
    } elseif ($cost <= $max_cost['value']) {
        $errors['max_cost_error'] = 'Ваша ставка не является наивысшей';
    } else {
        // id пользователя
        if (isset($_SESSION['name'])) {
            $user_id = mysqli_query($mysqli, "SELECT id FROM users WHERE name = '$_SESSION[name]'");
            $user_id = mysqli_fetch_assoc($user_id);
            $user_id = $user_id['id'];
        }


        $created_at = date('Y-m-d H:i:s');

        // вставляем все в базу
        $sql = "INSERT INTO stakes (value, user_id, lot_id, created_at) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($mysqli, $sql);
        mysqli_stmt_bind_param($stmt, 'siis', $cost, $user_id, $lot_id, $created_at);
        $res = mysqli_stmt_execute($stmt);

        if ($res) {
            include 'lot.php';
        } else {
            $errors['fail'] = 'Не удалось добавить ставку';
        }
    }
    if(count($errors)){
        include 'lot.php';
        $content = template('lot.php', ['errors' => $errors]);
    }
    
    print(template(
        '../templates/layout.php',
        [
            'user_avatar' => $user_avatar ?? '',
            'title' => 'Ошибка',
            'content' => $content,
        ]
    ));
} else {
    http_response_code(404);
    include('e404.php'); // provide your own HTML for the error page
    die();
}
