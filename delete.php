<?php
// When a user clicks the Delete button, this script deletes the book from the library

$user = $_GET['user'];
$isbn = trim($_GET['isbn']);

// Connect to the database
include("./includes/connect.php");

// Delete the library entry based on the ISBN and username
$DROP = "DELETE FROM library WHERE isbn='$isbn' AND user_id='$user';";
$mysqli->query($DROP);

mysqli_close($mysqli);
?>
