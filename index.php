<?php
require_once 'vendor/autoload.php';

require_once 'core/functions.php';
require_once 'core/db_connect.php';
include_once 'data/categories.inc.php';
include_once 'data/avatar.inc.php';

$title = 'Главная';
$name = $_SESSION['name'] ?? '';
if (!$mysqli) {
    $errors['db_connect_error'] = 'Ошибка подключения к БД';
} else {
    // для пагинации
    $currentPage = $_GET['page'] ?? 1;

    $items_per_page = 3;

    $rows = mysqli_query($mysqli, "SELECT COUNT(*) FROM lots WHERE is_open != 0");
    $rows = mysqli_fetch_row($rows);
    $totalPages = ceil($rows[0] / $items_per_page);
    $pages = range(1, $totalPages);
    $offset = ($currentPage - 1) * $items_per_page;

    // back-next btns
    $previousPage = $currentPage - 1;
    if($previousPage <= 0){
        $previousPage = 1;
    }
    $nextPage = $currentPage + 1;
    if($nextPage > $totalPages){
        $nextPage = $totalPages;
    }

    // $last_offset = ($totalPages - 1) * $items_per_page;
    // $previous_offset = (($currentPage - 1) - 1) * $items_per_page;
    // $next_offset = (($currentPage + 1) - 1) * $items_per_page;

    // выборка обьявлений
    $query = mysqli_query($mysqli, "SELECT l.*, c.name AS category
    FROM lots l JOIN categories c ON c.id = l.category_id
    WHERE l.is_open != 0 ORDER BY created_at DESC LIMIT $items_per_page OFFSET $offset");
    $lots = mysqli_fetch_all($query, MYSQLI_ASSOC);
}

if (count($errors)) {
    $content = template(
        'templates/errors.php',
        [
            'errors' => $errors
        ]
    );
} else {
    $content = template(
        'templates/index.php',
        [
            'lots' => $lots,
            'categories' => $categories,
            'pages' => $pages,
            'previousPage'=> $previousPage,
            'nextPage' => $nextPage

        ]
    );
}


print(template(
    'templates/layout.php',
    [
        'user_avatar' => $user_avatar ?? '',
        'title' => $title,
        'categories' => $categories ?? '',
        'content' => $content,
    ]
));
