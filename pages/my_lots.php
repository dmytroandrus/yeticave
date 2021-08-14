<?php
require_once '../vendor/autoload.php';

require_once '../core/functions.php';
require_once '../core/db_connect.php';
include_once '../data/categories.inc.php';
include_once '../data/avatar.inc.php';

if (isset($_SESSION['name'])) {
    if ($mysqli) {
        $my_lots = mysqli_query($mysqli, "SELECT l.* FROM lots l JOIN users u ON l.user_id = u.id WHERE u.name = '$_SESSION[name]'");
        $my_lots = mysqli_fetch_all($my_lots, MYSQLI_ASSOC);
    }
}
$content = template(
    '../templates/all-lots.php',
    [
        'title' => 'Мои лоты',
        'lots' => $my_lots,
        'categories' => $categories,
    ]
);

print(template(
    '../templates/layout.php',
    [
        'user_avatar' => $user_avatar ?? '',
        'title' => 'Мои лоты',
        'categories' => $categories ?? '',
        'content' => $content,
    ]
));
