<?php
// Grab the active user from the cookie created by the login
$user = $_COOKIE['username'];

// Get the search type (author, title) from the search form and encode it to accommodate spaces, commas, etc.
$author_search = ($_GET['inauthor'])?"inauthor:" . urlencode($_GET['inauthor']):"";
$title_search = ($_GET['intitle'])?"intitle:" . urlencode($_GET['intitle']):"";

// If searching both author and title at the same time, add the proper + to the search so the Google API likes it
$title_search = ($author_search)?"+$title_search":$title_search;

// The Google API lookup uses a simple string, constructed from your unique API key and the search values
$url = "https://www.googleapis.com/books/v1/volumes?q=$author_search$title_search&key=ENTER-YOUR-KEY-HERE&startIndex=0&maxResults=40";

// Get the data back from the Google database. If this function doesn't work, try curl
$string = file_get_contents($url);

// Parse the JSON
$results = json_decode($string);
$results_count = count($results->items);

// Create an array to hold the values we want to see. This will reduce some code redundancy.
$fields = array("selfLink","title","publisher","publishedDate","description","textSnippet","previewLink","language");

// Return the book information for each book in the JSON results until there are no more
for($x=0; $x < $results_count; $x++) {

        // Get the value for each item in the $fields array
        foreach($fields AS $key) {
                $$key = $results->items[$x]->volumeInfo->$key;
        }

        // Grab the values for items that require slightly different handling
        $isbn = $results->items[$x]->volumeInfo->industryIdentifiers[0]->identifier;
        $author = $results->items[$x]->volumeInfo->authors[0];
        $thumbnail = $results->items[$x]->volumeInfo->imageLinks->thumbnail;

        // Shorten the title and publishedDate for readability
        $title = substr($title,0,100);
        $publishedDate = substr($publishedDate,0,4);

        // Check the database to see if this book has already been read or wishlisted
        include("./includes/connect.php");
        $SQL = "SELECT * FROM library WHERE isbn = '$isbn';";
        $rs = $mysqli->query($SQL);
        $getValues = mysqli_fetch_assoc($rs);

        $readit = $getValues['readit'];
        $wishlist = $getValues['wishlist'];

        // Color the background of the book entries in the main view based on the results of above
        if(count($getValues) > 0) {
                $color = ($readit == 1)?"#8bb084":"#b0ae84";
        } else {
                $color = "#fff";
        }

        // The main presentation div for each book. You can change this based on what you want to see.
        echo "<div class='book' id='c$isbn' style='background-color: $color;'>
                        <a href='$previewLink' target='_blank'><img class='thumb' src='$thumbnail'></a>
                        <h2>$title</h2>
                        <h3>$author</h3>
                        $publishedDate<br />
                        <button class='read' id='b$isbn'>Read it!</button>
                        <button class='wishlist' id='w$isbn'>Wishlist</button><br />
                        <p>$description</p>
                        
                </div>";

        // Create an array of the form fields we want to save. Each book has two forms, one each for Read and Wishlist
        $form_fields = array("user","isbn","title","author","selfLink","publishedDate","thumbnail");
        $encoded_description = urlencode($description);

        // Create two forms with hidden content to use in the jQuery functions that mark books read or wishlisted
        echo "
        <div class='details'>
        <form id='b$isbn'>";
                foreach($form_fields AS $fkey) {
                        echo "\t<input type='hidden' name='$fkey' value='" . $$fkey. "'>\n";
                }
        echo "  <input type='hidden' name='description' value='$encoded_description'>
                <input type='hidden' name='read' value='1'>
        </form>
        <form id='w$isbn'>";
                foreach($form_fields AS $fkey) {
                        echo "\t<input type='hidden' name='$fkey' value='" . $$fkey. "'>\n";
                }
        echo "  <input type='hidden' name='description' value='$encoded_description'>
                <input type='hidden' name='wishlist' value='1'>
        </form>
        </div>";
}

?>

