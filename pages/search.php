<?php
require_once '../vendor/autoload.php';

require_once '../core/functions.php';
require_once '../core/db_connect.php';
include_once '../data/avatar.inc.php';
include_once '../data/categories.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['search']) && $_GET['search'] != '') {
        $search = htmlspecialchars($_GET['search']);
        if ($mysqli) {
            mysqli_query($mysqli, "CREATE FULLTEXT INDEX src ON lots(title, description)");
            $sql = "SELECT * FROM lots WHERE MATCH(title, `description`) AGAINST(?)";
            $stmt = mysqli_prepare($mysqli, $sql);
            mysqli_stmt_bind_param($stmt, 's', $search);
            mysqli_stmt_execute($stmt);
            $lots = mysqli_stmt_get_result($stmt);
            $lots = mysqli_fetch_all($lots, MYSQLI_ASSOC);
            if (!$lots) {
                $err = mysqli_error($mysqli);
            }
        }
    }else{
        $msg = 'Ничего не найдено';
    }

    $content = template(
        '../templates/search.php',
        [
            'lots' => $lots ?? '',
            'search' => $search ?? '',
            'err' => $err ?? '',
            'msg'=>$msg ?? ''
        ]
    );

    print(template(
        '../templates/layout.php',
        [
            'title' => 'Поиск',
            'user_avatar' => $user_avatar ?? '',
            'categories' => $categories,
            'content' => $content,
        ]
    ));
}
