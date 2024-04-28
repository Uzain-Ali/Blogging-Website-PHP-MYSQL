<?php
    require_once '../../functions/connect.php';
    require_once '../../functions/auth.php';
    $cat = 0;

    //Checking the data is submitted and not empty
     if(isset($_POST['name']) && $_POST['name'] !== '') {
        $cat_title=$_POST['name'];
        $sql = "SELECT * FROM categories where title='$cat_title'";
        $result = mysqli_query($conn, $sql);
        if($result){
            $num = mysqli_num_rows($result);
            if($num>0){
                $cat=1;  
            }else{
                    $sql = "INSERT INTO categories (title, created_at) values ('$cat_title',NOW());";
                    $result = mysqli_query($conn,$sql);
                    redirect('routes/categories.php');
     }
    }}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Category</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
</head>

<body>

<?php 
        if($cat){
            echo "<div class='alert alert-danger' role='alert'>
            Category Already Exist!</div>";
        }
        ?>
    <div id="app">
    <?php require_once '../../sections/nav-bar.php'; ?>

        <div class="container-fluid d-flex flex-column justify-content-center align-items-center">
            <div class="row">
                <div class="col-md-12 pt-3" style="width:900px">

                    <form action="create.php" method="post">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Enter Category Name">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>

                    </form>

                </div>
            </div>
        </div>

    </div>
    <?php require_once '../../sections/footer.php'; ?>


    <script src="<?= asset('assets/js/jquery.min.js') ?>"></script>
     <script src="<?= asset('assets/js/bootstrap.min.js') ?>"></script>
</body>

</html>