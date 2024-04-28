<?php

define('BASE_URL', 'http://localhost/Blogging-Website-PHP-MYSQL/');

function redirect($url) 
{    
     header('Location: ' . trim(BASE_URL, '/ ')  . '/' . trim($url, '/'));
     exit;
}

function url($url) 
{    
     return trim(BASE_URL, '/ ') . '/' . trim($url, '/');
}



require 'config.php';
$conn = mysqli_connect($config['server'],$config['username'], $config['password'], $config['database'] );

if(!$conn){
    die("Connection Error:". mysqli_connect_error());
}
?>