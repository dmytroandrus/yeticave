<?php
require_once '../vendor/autoload.php';

require_once '../core/functions.php';
require_once '../core/db_connect.php';
require_once '../data/avatar.inc.php';
include_once '../data/categories.inc.php';

// Получаем id товара
if (count($_GET) && isset($_GET['id'])) {
  $id = (int)htmlspecialchars($_GET['id']);
}
if (!$mysqli) {
  $errors['db_connect_error'] = 'Ошибка подключения к БД';
} else {
  $lot = mysqli_query($mysqli, "SELECT * FROM lots WHERE id = '$id'");
  $lot = mysqli_fetch_assoc($lot);

  $category = mysqli_query($mysqli, "SELECT * FROM categories c JOIN lots l ON c.id = l.category_id WHERE l.id = '$id'");
  $category = mysqli_fetch_assoc($category);

  $title = $lot['title'];

  // выборка для таблицы ставок
  $stakes = mysqli_query($mysqli, "SELECT s.*, u.name FROM stakes s JOIN users u ON s.user_id = u.id WHERE s.lot_id = '$id' ORDER BY s.value DESC");
  $cnt_stakes = mysqli_num_rows($stakes);
  $stakes = mysqli_fetch_all($stakes, MYSQLI_ASSOC);

  $max_stake = mysqli_query($mysqli, "SELECT s.*, u.name FROM stakes s JOIN users u ON s.user_id = u.id WHERE s.lot_id = '$id' ORDER BY s.value DESC");
  $max_stake = mysqli_fetch_assoc($max_stake);

}

if (!$lot) {
  http_response_code(404);
  include('e404.php'); // provide your own HTML for the error page
  die();
}

//Создем массив индексов просмотренных лотов для зписи в куки
// При первом заходе создаем куку
if (!isset($_COOKIE['seen_lots'])) {
  $array[] = $id;
  $array = json_encode($array);
  setcookie('seen_lots', $array, strtotime('+1 day'), '/');
} else {
  // Если кука существует
  // Десериализуем строку в массив
  $from_cookie = json_decode($_COOKIE['seen_lots']);
  if (!in_array($id, $from_cookie)) {
    $from_cookie[] = $id;
    // Серилизация массива в строку
    $array = json_encode($from_cookie);
    setcookie('seen_lots', $array, strtotime('+1 day'), '/');
  }
}

$content = template(
  '../templates/lot.php',
  [
    'title' => $title,
    'lot' => $lot,
    'category'=>$category,
    'stakes'=>$stakes,
    'cnt_stakes'=>$cnt_stakes,
    'max_stake'=>$max_stake
  ]
);

print(template(
  '../templates/layout.php',
  [
    'title' => $title,
    'user_avatar' => $user_avatar ?? '',
    'categories' => $categories,
    'content' => $content,
  ]
));
