<?php
require_once '../vendor/autoload.php';

require_once '../core/functions.php';
require_once '../core/db_connect.php';
require_once '../data/avatar.inc.php';
include_once '../data/categories.inc.php';
// Получаем id категории
if (count($_GET) && isset($_GET['id'])) {
  $category_id = (int)htmlspecialchars($_GET['id']);
}
if (!$mysqli) {
  $errors['db_connect_error'] = 'Ошибка подключения к БД';
} else {
  $category = mysqli_query($mysqli, "SELECT * FROM categories WHERE id = '$category_id'");
  $category = mysqli_fetch_assoc($category);

  $lots = mysqli_query($mysqli, "SELECT * FROM lots l JOIN categories c ON c.id = l.category_id WHERE c.id = '$category_id' AND l.is_open != 0 ORDER BY l.created_at DESC");
  $lots = mysqli_fetch_all($lots, MYSQLI_ASSOC);
}

if (!$lots) {
  http_response_code(404);
  include('e404.php'); // provide your own HTML for the error page
  die();
}

$content = template(
  '../templates/all-lots.php',
  [
    'title'=>$category['name'],
    'lots' => $lots,
    'category' =>$category,
  ]
);

print(template(
  '../templates/layout.php',
  [
    'title'=>$category['name'],
    'user_avatar' => $user_avatar ?? '',
    'categories' => $categories,
    'content' => $content,
  ]
));
