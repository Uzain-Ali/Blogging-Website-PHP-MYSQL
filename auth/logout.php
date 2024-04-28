<?php
include_once "../functions/connect.php";

session_start();
session_unset();
session_destroy();

redirect('auth/login.php');
?>