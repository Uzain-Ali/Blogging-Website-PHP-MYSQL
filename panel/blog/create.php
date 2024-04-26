<?php
require_once '../../functions/connect.php';
require_once '../../functions/auth.php';

$unauthorized = 0;

// Check if the URL contains the 'id' parameter
if (isset($_GET['id'])) {
    $blogId = $_GET['id'];


    $sql = "SELECT * FROM blogs WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $blogId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $blog = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    $user = $_SESSION['user'];
    $authorID = $blog['author_id'];

    // Check if the logged-in user is authorized 
    if (intval($user) !== $authorID) {
        $unauthorized = 1;
    }
}

// Check if the form is submitted
if(isset($_POST['title']) && $_POST['title'] !== '' && isset($_POST['cat_id']) && $_POST['cat_id'] !== '' && isset($_POST['content']) && $_POST['content'] !== '') 
{    
    $title = $_POST['title'];
    $cat_id = $_POST['cat_id'];
    $content = $_POST['content'];

    // Get the ID of the logged-in user from the session
    $author_id = $_SESSION['user']; 

    if (isset($_GET['id'])) {
        // If editing an existing blog post, update the database record
        $sql = "UPDATE blogs SET title = ?, cat_id = ?, content = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sisi", $title, $cat_id, $content, $blogId);
    } else {
        // If creating a new blog post, insert a new record into the database
        $sql = "INSERT INTO blogs (title, cat_id, content, created_at, author_id) VALUES (?, ?, ?, NOW(), ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sisi", $title, $cat_id, $content, $author_id);
    }

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    
    mysqli_close($conn);
    
    header('location:../../index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($blog) ? 'Edit Blog' : 'Create Blog' ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
</head>
<body>

        <?php
            if($unauthorized){
                    echo "<div class='alert alert-danger' role='alert'>
                    Your're not authorized to edit this blog</div>";
                }
            ?>
<section id="app">
<?php require_once '../section/login-signup-navBar.php'; ?>



    <section class="container-fluid">
        <section class="row">
            <section class="col-md-10 pt-3 ">

                <form action="" method="post">
                    <section class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" name="title" id="title" placeholder="Enter Title" value="<?= isset($blog) ? $blog['title'] : '' ?>">
                    </section>
                    <section class="form-group">
                        <label for="cat_id">Category</label>
                        <select class="form-control" name="cat_id" id="cat_id">
                            <?php
                            $sql = "SELECT * FROM categories";
                            $result = mysqli_query($conn, $sql);
                            if ($result) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                    <option value="<?= $row['id'] ?>" <?= isset($blog) && $row['id'] == $blog['cat_id'] ? 'selected' : '' ?>><?= $row['title'] ?></option>
                                    <?php
                                }
                                mysqli_free_result($result);
                                ?>
                                <?php
                            } else {
                                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                            }
                            ?>
                        </select>
                    </section>
                    <a class="btn btn-secondary border-primary mt-1 ml-1 " href="../category/create.php" role="button">Create Category</a>
                    <section class="form-group mt-2">
                        <label for="content">Content</label>
                        <textarea class="form-control" name="content" id="content" rows="5" placeholder="Enter Content"><?= isset($blog) ? $blog['content'] : '' ?></textarea>
                    </section>
                    <section class="form-group">
                        <button type="submit" name="submit" class="btn btn-primary"><?= isset($blog) ? 'Update' : 'Create' ?></button>
                    </section>
                </form>

            </section>
        </section>
    </section>

</section>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
