<?php
session_start();
include_once "../functions/connect.php";

$login = 0;
$invalid = 0;
$error='';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'])) {
        if (isset($_POST['email']) && $_POST['email'] !== ''
            && isset($_POST['password']) && $_POST['password'] !== '') {

            $email = $_POST['email'];
            $password = md5($_POST['password']);

            $sql = "SELECT id FROM users WHERE email='$email' AND password='$password'";
            $result = mysqli_query($conn, $sql);
            
            if ($result) {
                $num = mysqli_num_rows($result);
                
                if ($num > 0) {
                    $login = 1;
                    $row = mysqli_fetch_assoc($result);
                    $userId = $row['id'];
                    $_SESSION['user'] = $userId;
                    header('location:../index.php');
                } else {
                    $invalid = 1;
                }
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <title>Document</title>
</head>
<body>
<div class="app">
    <?php
            if($invalid){
                    echo "<div class='alert alert-danger' role='alert'>
                    Invalid Login</div>";
                }
            ?>

        <?php require_once "login-navbar.php"?>

        <div class="d-flex flex-column justify-content-center align-items-center" style="height: 100vh; background-color: white;">
                       <h1 class="" >Login</h1>
                    <section class="bg-light my-0 px-2" style="width:500px">
                    <small class="text-danger"><?php if ($error !== '') echo $error; ?></small>
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" autocomplete="off" placeholder="Enter Email" name="email">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" autocomplete="off" placeholder="Enter Password" name="password">
                        </div>

                        <button type="submit" class="btn btn-primary w-100 btn-success my-3" name="login">Login</button>
                        <a class="text-decoration-none " href="register.php">Register</a>

                    </form>
            </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
    
</body>
</html>