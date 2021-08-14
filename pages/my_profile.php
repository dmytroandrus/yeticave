<?php
require_once '../vendor/autoload.php';

require_once '../core/db_connect.php';
require_once '../core/functions.php';
require_once '../data/avatar.inc.php';
include_once '../data/categories.inc.php';

$content = template(
    '../templates/my_profile.php',
    [
      'title' => 'Мой профиль',
    ]
  );
  
  print(template(
    '../templates/layout.php',
    [
      'title' => 'Мой профиль',
      'user_avatar' => $user_avatar,
      'categories' => $categories,
      'content' => $content,
    ]
  ));