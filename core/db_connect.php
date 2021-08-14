<?php
// error_reporting(null);
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'yeticave';

$mysqli = mysqli_connect($host, $user, $password, $database);
if ($mysqli) {
    mysqli_set_charset($mysqli, 'utf8');
}
