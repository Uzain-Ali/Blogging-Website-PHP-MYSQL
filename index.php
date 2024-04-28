<?php
session_start(); 
include_once "functions/connect.php";

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
    <?php include_once "sections/nav-bar.php"?>
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
                            // Check if the logged-in user is the author of this blog
                            if (isset($_SESSION['user']) && $_SESSION['user'] == $blog['author_id']) { ?>
                                <span class="d-flex justify-content-center">
                                    <p><a class="small text-danger" href="<?= url('content/blog/delete.php?delete='.$blog['id']) ?>" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a></p>
                                    <p><a class=" small  text-success ml-2" href="<?= url('content/blog/create.php?id='.$blog['id']) ?>">Edit</a></p>              
                            </span>
                            <?php } ?>
                            </div>
                            <h2 class="h5 text-truncate d-flex flex-column justify-content-center"><?= $blog['title'] ?>
                             </h2>
                        </div>    
                        <p><?= substr($blog['content'], 0, 80) ?></p> 
                        <p><a class="btn btn-secondary" href="<?= url('routes/view-details.php?blog_id='. $blog['id'])?>" role="button">Details</a></p> 
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
<?php require_once "sections/footer.php"?>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
