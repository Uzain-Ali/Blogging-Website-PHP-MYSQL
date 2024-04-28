<?php
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-secondary bg-gradient">

    <a class="navbar-brand " href="<?= url('/')?>">Thought Threads</a>
    <button class="navbar-toggler " type="button " data-toggle="collapse " data-target="#navbarSupportedContent ">
        <span class="navbar-toggler-icon "></span>
    </button>

    <div class="collapse navbar-collapse " id="navbarSupportedContent ">
        <ul class="navbar-nav mr-auto ">
            <li class="nav-item active ">
                <a class="nav-link " href="<?= url('/')?>">Home <span class="sr-only ">(current)</span></a>
            </li>

            <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">
                Categories
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <?php
                $sql = "SELECT * FROM categories";
                $result = mysqli_query($conn, $sql);

                if ($result) {
                    while ($category = mysqli_fetch_assoc($result)) {
                        ?>
                        <a class="dropdown-item" href="<?= url('routes/categories.php?cat_id='. $category['id']) ?>"><?= $category['title'] ?></a>
                <?php
                    }
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
                ?>
                </li>
                <?php 
                if(isset($_SESSION['user'])){?>
                <li>
                <a class="nav-link" href="<?= url('routes/my-blogs.php')?>">My Blog <span class="sr-only ">(current)</span></a>
                </li>
                <?php }
                ?>
                        </ul>
    </div>

    <div class="d-flex ">

                <?php 
                if (!isset($_SESSION['user'])) {
                    ?>
        <a class="text-decoration-none text-white px-2 " href="<?= url('auth/register.php')?>">register</a>
        <a class="text-decoration-none text-white " href="<?= url('auth/login.php')?>">login</a>
        <?php
                } else { ?>
        <div class="mr-5 mt-1 d-flex">
            <p><a class="btn btn-secondary border-success mt-2 " href="<?= url('content/blog/create.php')?>" role="button">Create Blog</a></p> 
        </div>
        <a class="text-decoration-none text-white px-2 mt-3" href="<?= url('auth/logout.php')?>">Logout</a>

        <?php } ?>

    </div>
</nav>




