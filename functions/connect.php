<?php
require 'config.php';
$conn = mysqli_connect($config['server'],$config['username'], $config['password'], $config['database'] );

if(!$conn){
    die("Connection Error:". mysqli_connect_error());
}
?>