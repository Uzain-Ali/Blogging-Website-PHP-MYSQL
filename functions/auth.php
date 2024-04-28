<?php
session_start();
include_once "connect.php";
if(!isset($_SESSION['user']))
{
    redirect('auth/login.php');
}