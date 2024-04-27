<?php
session_start();
include_once "./functions/connect.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <title>Category Page</title>
</head>
<body>
    <div class="app">
         <?php require_once "sections/nav-bar.php"?>

         <div class="container my-5">
            <?php
                $notFound=0;
                $noData=0;

                if(isset($_GET['cat_id']) && $_GET['cat_id'] !== ''){
                    $cat_id = $_GET['cat_id'];
                    $sql = "SELECT * FROM categories WHERE id = ?";
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, "i", $cat_id);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    $category = mysqli_fetch_assoc($result);
                    if ($category !== null) {
                        ?>
                        <div class="row">
                        <div class="col-12">
                            <h1><?= $category['title'] ?></h1>
                            <hr>
                        </div>
                    </div>
                    <div class="row">

                <?php
                    $sql = "SELECT blogs.* FROM categories JOIN blogs ON categories.id = blogs.cat_id WHERE categories.id = ?";
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, "i", $cat_id);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    if(mysqli_num_rows($result)==0){
                        $noData=1;
                    }else{
                        while ($blog = mysqli_fetch_assoc($result)) {
                    ?>
                                    <div class="col-md-4">
                                        <div class="mb-2 overflow-hidden" style="max-height: 15rem;"><img class="img-fluid" src="" alt=""></div>
                                        <h2 class="h5 text-truncate"><?= $blog['title'] ?></h2>
                                        <p><?= substr($blog['content'], 0, 80) ?></p>
                                        <p><a class="btn btn-primary" href="" role="button">Details</a></p>
                                    </div>
                                    <?php
                     }
                    }
            ?>
        </div>
<?php
    }else{
        $notFound=1;
    }

}else{
    $notFound=1;
}?>

<?php 
    if($notFound){?>
        <div class="row">
            <div class="col-12">
                <h1>Category not found</h1>
            </div>
        </div>
    <?php }else{
        if($noData){
        ?>
                    <div class="row">
            <div class="col-12">
                
                <h1>No blog found</h1>
            </div>
        </div>
        <?php
    }}?>
    </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>
</html>