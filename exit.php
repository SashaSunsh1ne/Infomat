<?php
unset($_COOKIE['username']);
setcookie('username', '', -1, 'Informat/');
$home_url = 'index.php';
header('Location: ' . $home_url);
