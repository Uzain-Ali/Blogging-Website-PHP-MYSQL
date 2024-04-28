<?php
require_once '../../functions/connect.php';
require_once '../../functions/auth.php';
require_once 'update-add.php'; 
require_once 'get-data.php'; 

//Check if user is inauthorized then show message
if($unauthorized){
        echo "<div class='alert alert-danger' role='alert'>
        Your're not authorized to edit this blog</div>";
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

<div id="app">
<?php require_once '../../sections/nav-bar.php'; ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-10 pt-3 m-auto">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" name="title" id="title" placeholder="Enter Title" value="<?= isset($blog) ? $blog['title'] : '' ?>">
                    </div>
                    <div class="form-group">
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
                    </div>
                    <a class="btn btn-secondary border-primary mt-1 ml-1 " href="../category/create.php" role="button">Create Category</a>
                    <div class="form-group mt-2">
                        <label for="content">Content</label>
                        <textarea class="form-control" name="content" id="content" rows="5" placeholder="Enter Content"><?= isset($blog) ? $blog['content'] : '' ?></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="submit" class="btn btn-primary"><?= isset($blog) ? 'Update' : 'Create' ?></button>
                    </div>
                </form>

            </div>
        </div>
    </div>

</div>

<?php require_once '../../sections/footer.php'; ?>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
