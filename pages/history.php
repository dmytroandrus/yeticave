<?php
require_once '../vendor/autoload.php';

require_once '../core/functions.php';
require_once '../core/db_connect.php';
require_once '../data/avatar.inc.php';
include_once '../data/categories.inc.php';

if(isset($_COOKIE['seen_lots'])){
	$seen_lots = json_decode($_COOKIE['seen_lots']);

	foreach ($seen_lots as $id) {
		$lot = mysqli_query($mysqli, "SELECT * FROM lots WHERE id = '$id'");
		$lot = mysqli_fetch_assoc($lot);
		$lots_history[] = ($lot);
	}

	$content = template('../templates/all-lots.php', 
	    [
	        'lots'=>$lots_history,
	        'sellDate'=>lastSellDate('+1 day'),
	    ]);
}else{
	$content = template('../templates/all-lots.php', 
	    [
	        'no_lots'=>'Список пуст',
	    ]);
}
	
	print(template('../templates/layout.php', 
	    [
	    'title'=>'Недавно просмотренные',
	    'user_avatar'=>$user_avatar,
	    'categories'=>$categories,
	    'content'=>$content,
	    ]));
	