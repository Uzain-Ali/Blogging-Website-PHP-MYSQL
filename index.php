<?php
include_once "functions/connect.php";

session_start(); 

include_once "functions/connect.php";

if(isset($_GET['delete'])){
    $deleteID = $_GET['delete'];
    
    // Check if the logged-in user is authorized to delete this blog
    if(isset($_SESSION['user'])) {
        $loggedInUserID = $_SESSION['user'];
        
        $authorQuery = "SELECT author_id FROM blogs WHERE id = $deleteID";
        $authorResult = mysqli_query($conn, $authorQuery);
        
        if($authorResult && mysqli_num_rows($authorResult) > 0) {
            $authorData = mysqli_fetch_assoc($authorResult);
            $authorID = $authorData['author_id'];
            
            if($loggedInUserID == $authorID) {
                // If authorized proceed with deletion
                $sql = "DELETE FROM blogs WHERE id = $deleteID";
                $result= mysqli_query($conn, $sql);
                
                if($result) {
                    header('location:index.php');
                } else {
                    echo "Error: Failed to delete blog.";
                }
            } else {
                echo "You are not authorized to delete this blog.";
            }
        } else {
            echo "Error: Blog not found.";
        }
    } else {
        echo "You need to be logged in to delete a blog.";
    }
}





?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <title>Blogging Website</title>
</head>
<body>

<div id="app">
    <?php require_once "sections/nav-bar.php"?>
    <div class="container my-5 text-center">
        <h4 class="my-5 h1">Thoughts<h4>

        <div class="row">
            <?php 
                    $sql = "SELECT * FROM blogs";
                    $result = mysqli_query($conn, $sql);

                    if($result){
                        $count = 0;
                        while ($blog = $result->fetch_assoc()) { 
                            if ($count % 3 == 0) {
                                if ($count != 0) {
                                    echo '</div>'; 
                                }
                                echo '<div class="row mb-5">'; 
                            }
                            ?>
                            <div class="col-md-4">
                                <div class="d-flex flex-column ">
                                    <h2 class="h5 text-truncate d-flex flex-column justify-content-center"><?= $blog['title'] ?>
                                    <?php 
                                        if (isset($_SESSION['user'])) {
                                    ?>
                                        <div class="d-flex justify-content-center">
                                                <p><a class="h6 text-danger" href="index.php?delete=<?= $blog['id'] ?>" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a></p>
                                                <p><a class="h6 text-success ml-2" href="panel/blog/create.php?id=<?= $blog['id'] ?>">Edit</a></p>
                                            
                                        </div>
                                    <?php }else{?>
                                    </h2> 
                                    <?php } ?>
                                </div>    
                                <p ><?= substr($blog['content'], 0, 80) ?></p> 
                                <p><a class="btn btn-secondary" href="view-details.php?blog_id=<?= $blog['id'] ?>" role="button">Details</a></p> 
                            </div>
                            <?php
            $count++;
        }
        echo '</div>'; // Close the last row
    } else {
        echo "Error: " . mysqli_error();
    }
    ?>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>
</html>