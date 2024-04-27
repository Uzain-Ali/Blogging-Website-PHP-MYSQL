<?php
include_once "functions/connect.php";
session_start(); 
$unauthorized = 0;

if (isset($_GET['delete'])) {
    $deleteID = $_GET['delete'];
    
    // Check if the logged-in user is authorized to delete this blog
    if (isset($_SESSION['user'])) {
        $loggedInUserID = $_SESSION['user']; 
        
        $authorQuery = "SELECT author_id FROM blogs WHERE id = $deleteID";
        $authorResult = mysqli_query($conn, $authorQuery);
        
        if ($authorResult && mysqli_num_rows($authorResult) > 0) {
            $authorData = mysqli_fetch_assoc($authorResult);
            $authorID = $authorData['author_id'];
            
            if ($loggedInUserID == $authorID) {
                // If authorized proceed with deletion
                $sql = "DELETE FROM blogs WHERE id = $deleteID";
                $result = mysqli_query($conn, $sql);
                
                if ($result) {
                    header('location:index.php');
                } 
            } else {
                $unauthorized = 1;
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
    <title>Blogging Website</title>
</head>
<body>
<?php
if ($unauthorized) {
    echo "<div class='alert alert-danger' role='alert'>You're not authorized to edit this blog</div>";
}
?>
<div id="app">
    <?php require_once "sections/nav-bar.php"?>
    <div class="container my-5 text-center">
        <h4 class="my-5 h1">Thoughts</h4>
        <div class="row">
            <?php 
            $sql = "SELECT * FROM blogs";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                $count = 0;
                while ($blog = $result->fetch_assoc()) { 
                    if ($count % 3 == 0) {
                        if ($count != 0) {
                            echo '</div>'; 
                        }
                        echo '<div class="row mb-5  w-100">'; 
                    }
                    ?>
                    <div class="col-md-4">
                        <div class="d-flex flex-column ">
                        <div class="d-flex justify-content-around">
                             <span class="date-time small "><?= $blog['created_at'] ?></span>
                            <?php 
                            $session =$_SESSION['user'];
                            $authorID=$blog['author_id'];
                            // Check if the logged-in user is the author of this blog
                            if ($session == $authorID) { ?>
                                <span class="d-flex justify-content-center">
                                    <p><a class="small text-danger" href="index.php?delete=<?= $blog['id'] ?>" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a></p>
                                    <p><a class=" small  text-success ml-2" href="content/blog/create.php?id=<?= $blog['id'] ?>">Edit</a></p>              
                            </span>
                            <?php } ?>
                            </div>
                            <h2 class="h5 text-truncate d-flex flex-column justify-content-center"><?= $blog['title'] ?>
                             </h2>
                        </div>    
                        <p><?= substr($blog['content'], 0, 80) ?></p> 
                        <p><a class="btn btn-secondary" href="view-details.php?blog_id=<?= $blog['id'] ?>" role="button">Details</a></p> 
                    </div>
                    <?php
                    $count++;
                }
                echo '</div>'; //closing
            } else {
                echo "Error: " . mysqli_error($conn);
            }
            ?>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
