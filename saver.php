<?php
// This file takes form content, fed by the jQuery functions and forms on /booklist/index.php
$user = $_GET['user'];
$isbn = trim($_GET['isbn']);
$title = $_GET['title'];
$author  = $_GET['author'];
$selfLink = $_GET['selfLink'];
$publishedDate = $_GET['publishedDate'];
$thumbnail = $_GET['thumbnail'];
$description = $_GET['description'];
$read = ($_GET['read'])?$_GET['read']:0;
$wishlist = ($_GET['wishlist'])?$_GET['wishlist']:0;


// Connect to the database
include("./includes/connect.php");

// Create an SQL INSERT query to save details of the book
$BOOK = "INSERT IGNORE INTO books(isbn, title, author, selfLink, publishedDate, thumbnail, description) VALUES('$isbn', '$title', '$author', '$selfLink', '$publishedDate', '$thumbnail', '$description');";

// If the <div id='saver'></div> on the index.php page were not set to hidden, these words would show up on click.
if($mysqli->query($BOOK)) {
	echo "Book saved.<br />";
}

// This deletes any previous entry to avoid any duplication errors
$DROP = "DELETE FROM library WHERE isbn='$isbn';";
$mysqli->query($DROP);

// Another SQL INSERT query to save the book entry to the user's library
$LIBRARY = "INSERT INTO library(isbn, user_id, readit, wishlist) VALUES('$isbn', '$user', $read, $wishlist);";

// A book can be read or on the wishlist, but not both.
if($read == "1") {
	if($mysqli->query($LIBRARY)) {
		echo "Saved as read.";
	}
}
if($wishlist == "1") {
	if($mysqli->query($LIBRARY)) {
		echo "Saved to wishlist.";
	}
}

mysqli_close($mysqli);
?>
