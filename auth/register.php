<?php
include_once "../functions/connect.php";
$user=0;
$success=0;
$length=0;
$error = '';
if(isset($_POST['signup'])){
    if(isset($_POST['username']) && $_POST['username'] !== '' 
        && isset($_POST['password']) && $_POST['password'] !== '' 
        && isset($_POST['email']) && $_POST['email'] !== '' ){
            if(strlen($_POST['password'])<5){
                $length=1;
            }else{
                $username =$_POST['username'];
                $password =md5($_POST['password']);
                $email =$_POST['email'];


                $sql = "SELECT * FROM users where email='$email'";
                $result = mysqli_query($conn, $sql);

                if($result){
                    $num = mysqli_num_rows($result);
                    if($num>0){
                        $user=1;
                    }else{
                            $sql="INSERT INTO users(username, password, email, created_at) values('$username','$password', '$email',NOW())";
                            $result = mysqli_query($conn, $sql);

                            if($result){
                                $success=1;
                            }else{
                                echo  die("Error:". mysqli_error());
                            }
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
<?php
        if($user){
            echo "<div class='alert alert-danger' role='alert'>
            User Already Exist!</div>";
        }else{
         if($length){
            echo "<div class='alert alert-danger' role='alert'>
            Password length must be greater than five characters</div>";
         }else{
            if($success){
                echo "<div class='alert alert-success' role='alert'>
                SignUp Successfull!</div>";
            }
        }
    }
    ?>


    <div class="app">
        <?php require_once "../sections/nav-bar.php"?>

        <div class="d-flex flex-column justify-content-center align-items-center" style="height: 100vh; background-color: white;">
                       <h1 class="" >Sign Up</h1>
                    <section class="bg-light my-0 px-2" style="width:500px">
                    <small class="text-danger"><?php if ($error !== '') echo $error; ?></small>
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" id="username" autocomplete="off" placeholder="Enter Username" name="username">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" autocomplete="off" placeholder="Enter Password" name="password">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" autocomplete="off" placeholder="Enter Email" name="email">
                        </div>
                        <button type="submit" class="btn btn-primary w-100 btn-success my-3" name="signup">Sign Up</button>
                        <a class="text-decoration-none" href="login.php">Login</a>
                    </form>
            </div>
    </div>
    <?php require_once "../sections/footer.php"?>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>
</html>