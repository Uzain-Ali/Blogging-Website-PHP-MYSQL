
<?php
    session_start();
    include_once "../functions/connect.php";
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
        <?php require_once "../sections/nav-bar.php"?>

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                <?php

    // Check for exist post
    $query = "SELECT blogs.*, categories.title AS category_name 
            FROM blogs 
            JOIN categories ON blogs.cat_id = categories.id 
            WHERE blogs.id = ?";
                $stmt = mysqli_prepare($conn, $query);
                mysqli_stmt_bind_param($stmt, "i", $_GET['blog_id']);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $blog = mysqli_fetch_assoc($result);
                if ($blog !== null) {
    ?>
        <div class="">
            <span class="d-flex justify-content-end">
            <?php 
                $session =$_SESSION['user'];
                $authorID=$blog['author_id'];
                // Check if the logged-in user is the author of this blog
                if ($session == $authorID) { ?>
        
            <?php }?>
        </div>
        <h1 class="my-5 d-flex justify-content-between"><?= $blog['title'] ?>  
        <?php 
                $session =$_SESSION['user'];
                $authorID=$blog['author_id'];
                if ($session == $authorID) { ?>    
        <span class="">      
            <span><a class="h5 text-danger" href="<?= url('content/blog/delete.php?delete='. $blog['id']) ?>" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a></span>
            <span><a class="h5 text-success ml-2" href="<?= url('content/blog/create.php?id='. $blog['id']) ?>">Edit</a></span>
            </span>
            <?php }?>
    </h1>

        <h5 class="d-flex justify-content-between align-items-center my-4">
            <a href="<?= url('routes/categories.php?cat_id='. $blog['cat_id']) ?>"><?= $blog['category_name'] ?></a>

            <span class="date-time"><?= $blog['created_at'] ?></span>
        </h5>
        <article class="bg-article p-3"><?= $blog['content'] ?></article>


    <?php
    } else {
    ?>
        <section>Post not found!</section>
    <?php
    }
    ?>
                </div>
            </div>
        </div>

        

        <?php require_once "../sections/footer.php"?>




        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" ></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
    </body>
    </html>