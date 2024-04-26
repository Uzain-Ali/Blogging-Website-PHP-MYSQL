<?php
include_once "./functions/connect.php";
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-secondary bg-gradient">

    <a class="navbar-brand " href="../index.php">Thought Threads</a>
    <button class="navbar-toggler " type="button " data-toggle="collapse " data-target="#navbarSupportedContent ">
        <span class="navbar-toggler-icon "></span>
    </button>

    <div class="collapse navbar-collapse " id="navbarSupportedContent ">
        <ul class="navbar-nav mr-auto ">
            <li class="nav-item active ">
                <a class="nav-link " href="./index.php">Home <span class="sr-only ">(current)</span></a>
            </li>

            <?php
            $sql = "SELECT * FROM categories";
            $result = mysqli_query($conn, $sql);

            if($result){
                while($category = mysqli_fetch_assoc($result)){?>
                        <li class="nav-item">
                        <a class="nav-link" href="categories.php?cat_id=<?= $category['id'] ?>"><?= $category['title'] ?></a>
                        </li>
                    <?php }
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
            ?>
        </ul>
    </div>

    <div class="d-flex ">

                <?php 
                if (!isset($_SESSION['user'])) {
                    ?>
        <a class="text-decoration-none text-white px-2 " href="./auth/register.php">register</a>
        <a class="text-decoration-none text-white " href="./auth/login.php">login</a>
        <?php
                } else { ?>
        <div class="mr-5 mt-1 d-flex">
            <p><a class="btn btn-secondary border-success mt-2 " href="panel\blog\create.php" role="button">Create Blog</a></p> 
            <p><a class="btn btn-secondary border-primary mt-2 ml-1" href="panel\category\create.php" role="button">Create Category</a></p> 
        </div>
        <a class="text-decoration-none text-white px-2 mt-3" href="./auth/logout.php">Logout</a>

        <?php } ?>

    </div>
</nav>




