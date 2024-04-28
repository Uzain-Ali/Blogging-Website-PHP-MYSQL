<?php
session_start();
include_once "../../functions/connect.php";
//initialize to check the user is authorized or not
$unauthorized = 0;

//to get delete id of respective blog from url 
if (isset($_GET['delete'])) {
    $deleteID = $_GET['delete'];
    
    // Check if the logged-in user is authorized to delete this blog
    if (isset($_SESSION['user'])) {
        $userID = $_SESSION['user']; 
        $sql = "SELECT author_id FROM blogs WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $deleteID);
        mysqli_stmt_execute($stmt);
        $authorResult = mysqli_stmt_get_result($stmt);
        
        if ($authorResult && mysqli_num_rows($authorResult) > 0) {
            $authorData = mysqli_fetch_assoc($authorResult);
            $authorID = $authorData['author_id'];


            //to check the user id is same as the author id
            if ($userID == $authorID) {
                // If authorized proceed with deletion
                $sql = "DELETE FROM blogs WHERE id = ?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "i", $deleteID);
                $result = mysqli_stmt_execute($stmt);
                
                if ($result) {
                    redirect('routes/my-blogs.php');

                } else {
                    echo "Error: " . mysqli_error($conn);
                }
            } else {
                $unauthorized = 1;
            }
        } 
    }
}

?>

