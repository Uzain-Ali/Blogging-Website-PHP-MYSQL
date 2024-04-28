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
    <title>Blogging Website</title>
</head>
<body>
<div id="app">
    <?php include_once "../sections/nav-bar.php"?>
    <div class="container my-5 text-center">
        <?php
        // fetching all fields from categories table
        $sql = "SELECT * FROM categories";
        $categories_result = mysqli_query($conn, $sql);

        // Loop through categories to join the blogs and categories tables
        while ($category = mysqli_fetch_assoc($categories_result)) { 
            $cat_id = $category['id'];
            $author_id = $_SESSION['user'];
            $sql = "SELECT blogs.*, categories.title AS cat_title FROM blogs JOIN categories ON blogs.cat_id = categories.id WHERE blogs.cat_id = ? AND blogs.author_id = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ii", $cat_id, $author_id);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            // Display category name title heading if there are blogs related to it
            if (mysqli_num_rows($result) > 0) {
                echo '<h4 class="my-5 h1">'.$category['title'].'</h4>';
            }

            // Display blogs related to the respective category
            echo '<div class="row">';
            while ($blog = mysqli_fetch_assoc($result)) { 
                ?>
                <div class="col-md-4">
                    <div class="d-flex flex-column">
                        <div class="d-flex justify-content-around">
                            <span class="date-time small"><?= $blog['created_at'] ?></span>
                            <span class="d-flex justify-content-center">
                                <p><a class="small text-danger" href="<?= url('content/blog/delete.php?delete='.$blog['id']) ?>" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a></p>
                                <p><a class="small text-success ml-2" href="<?= url('content/blog/create.php?id='.$blog['id']) ?>">Edit</a></p>              
                            </span>
                        </div>
                        <h2 class="h5 text-truncate"><?= $blog['title'] ?></h2>
                        <p><?= substr($blog['content'], 0, 80) ?></p> 
                        <p><a class="btn btn-secondary" href="<?= url('routes/view-details.php?blog_id='. $blog['id'])?>" role="button">Details</a></p> 
                    </div>
                </div>
                <?php
            }
            echo '</div>'; 
        }
        ?>
    </div>
</div>
<?php require_once "../sections/footer.php"?>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
