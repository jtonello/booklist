<?php
// This function creates the lists for the Read and Wishlist tabs on /booklist/index.php
function lists($sql,$type) {

        include("./includes/connect.php");
        $rrs = $mysqli->query($sql);

        while($row = $rrs->fetch_array()) {
                $isbn = $row['isbn'];
                $title = $row['title'];
                $author = $row['author'];
                $publisheddate = $row['publisheddate'];
                $thumbnail = $row['thumbnail'];
                $description = urldecode($row['description']);
                $selfLink = $row['selfLink'];
                $user = $row['user_id'];
                //$user = "your@emailaddress.com";

                echo "
                <div class='book' id='c$isbn'>
                        <a href='$previewLink' target='_blank'><img class='thumb' src='$thumbnail'></a>
                        <h2>$title</h2>
                        <h3>$author</h3>
                        $publisheddate<br />";

                        if($type == "read") {
                                echo "<button class='remove' id='r$isbn'>Delete</button>";
                        }

                        if($type == "wishlist") {
                                echo "<button class='read' id='b$isbn'>Read it!</button> ";
                                echo "<button class='remove' id='r$isbn'>Delete</button>";
                                echo "
                                        <div class='details'>
                                        <form id='b$isbn'>
                                                <input type='hidden' name='user' value='$user'>
                                                <input type='hidden' name='isbn' value='$isbn'>
                                                <input type='hidden' name='title' value='$title'>
                                                <input type='hidden' name='author' value='$author'>
                                                <input type='hidden' name='selfLink' value='$selfLink'>
                                                <input type='hidden' name='publishedDate' value='$publishedDate'>
                                                <input type='hidden' name='thumbnail' value='$thumbnail'>
                                                <input type='hidden' name='description' value='$encoded_description'>
                                                <input type='hidden' name='read' value='1'>
                                        </form>
                                        </div>";
                        }
                        echo "<p>$description</p>
                </div>";

        }

        mysqli_close($mysqli);

}

?>
