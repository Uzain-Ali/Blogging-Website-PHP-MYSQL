<?php
require_once '../../functions/connect.php';
require_once '../../functions/auth.php';

$unauthorized = 0;

// Check if the URL contains the 'id'
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

    // Check the user is authorized?
    if (intval($user) !== $authorID) {
        $unauthorized = 1;
    }
}

// Check form is submitted?
if(isset($_POST['title']) && $_POST['title'] !== '' && isset($_POST['cat_id']) && $_POST['cat_id'] !== '' && isset($_POST['content']) && $_POST['content'] !== '') 
{    
    $title = $_POST['title'];
    $cat_id = $_POST['cat_id'];
    $content = $_POST['content'];

    // Get the ID of the logged-in user from the session
    $author_id = $_SESSION['user']; 

    //updating
    if (isset($_GET['id'])) {
        $sql = "UPDATE blogs SET title = ?, cat_id = ?, content = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sisi", $title, $cat_id, $content, $blogId);
    }
    //Inserting data
     else {
        $sql = "INSERT INTO blogs (title, cat_id, content, created_at, author_id) VALUES (?, ?, ?, NOW(), ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sisi", $title, $cat_id, $content, $author_id);
    }

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    
    mysqli_close($conn);
    //redirecting 
    redirect('routes/my-blogs.php');

}
?>
