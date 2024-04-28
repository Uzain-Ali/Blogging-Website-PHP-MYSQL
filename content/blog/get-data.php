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
?>