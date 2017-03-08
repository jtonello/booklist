<?php
        // Determine if the user is logged in by checking the cookie. If not, send the user back to the login page
        $user = $_COOKIE['username'];
        if(!$user){
                header('Location: /index.php');         # Note that this file is called login.php. It should be
        }                                               # renamed and moved to the folder one level above /booklist/.

        // Include functions to use later
        include("./includes/functions.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>My Library</title>
<!-- These scripts and css documents can be saved locally -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script>
// The contents of this script block is all jQuery
$(document).ready(function() {
        
        // This turns the 'tabs' div into graphical tabs using jQueryi UI
        $( "#tabs" ).tabs();

        // Perform the search via a simple AJAX function
        $("button#search").click(function() {
                var query = $("form#main").serialize();
                $("div#results").load("booklist.php?" + query);
                return false;
        });
        
        // Mark a book read
        $(document).on("click", "button.read", function() {
                var isbn = $(this).attr("id");
                var rawisbn = isbn.substr(1,isbn.length);
                var readQuery = $("form#" + isbn).serialize();
                $("div#saver").load("saver.php?" + readQuery);
                $("div#c" + rawisbn).css('background-color','#8bb084').slideToggle();
        });

        // Mark a book for the wishlist
        $(document).on("click", "button.wishlist", function() {
                var isbn = $(this).attr("id");
                var rawisbn = isbn.substr(1,isbn.length);
                var wishlistQuery = $("form#" + isbn).serialize();
                $("div#saver").load("saver.php?" + wishlistQuery);
                $("div#c" + rawisbn).css('background-color','#b0ae84').slideToggle();
        });

        // Delete a book from a user's list
        $(document).on("click", "button.remove", function() {
                var isbn = $(this).attr("id");
                var rawisbn = isbn.substr(1,isbn.length);
                var deleteQuery = "isbn=" + rawisbn + "&user=" + "<?php echo $user; ?>";
                if(confirm("Are you sure? This cannot be undone!")) {
                        $("div#saver").load("delete.php?" + deleteQuery);
                        $("div#c" + rawisbn).css('background-color', '#fff').slideToggle();
                }
        });

});

</script>
<!-- This CSS could be saved in a separate .css file, but it can be easier to edit it here until you're done. -->
<style type="text/css">
        body {
                width: 80%;
                margin: auto;
                font-family: sans-serif;
                font-size: .9em;
        }

        div.book {
                float: left;
                margin: 5px 10px 30px 0;
                padding: 25px 5px 5px 5px;
                width: 99%;
                height: 220px;
                background-color: #eee;
                overflow-y: auto;
        }

        h2, h3 {
                margin: 0;
                padding: 0;
                font-size: 1.5em;
        }

        h3 {
                font-size: 1.2em;
        }

        img.thumb {
                border: solid 1px #cacaca;
                float: left;
                margin-right: 8px;
                width: 130px;
                height: 200px;
        }

        div#saver {
                display: none;
        }

        .ui-tabs-panel {
                height: auto;
                overflow-y: auto;
        }

        input {
                margin-bottom: 4px;
                padding-left: 3px;
        }
</style>

</head>
<body>
<!-- jQuery UI turns the following into graphical tabs. -->        
<div id="tabs">
        <ul>
                <li><a href="#tabs-1">Search</a></li>
                <li><a href="#tabs-2">Read</a></li>
                <li><a href="#tabs-3">Wishlist</a></li>
        </ul>
        <div id="tabs-1">
                <form id="main">
                        <input type="text" name="inauthor" id="inauthor" placeholder="Author"><br />
                        <input type="text" name="intitle" id="intitle" placeholder="Title"><br />
                        <button id="search">Search</button><input type="reset">
                </form>
                <div id="results"></div>
        </div>
        <div id="tabs-2">
                <?php
                // The lists() function is in /booklist/includes/functions.php
                
                $READ = "SELECT * FROM books b LEFT JOIN library l USING(isbn) WHERE l.readit = 1 AND user_id = '$user' ORDER BY b.title;";
                lists($READ,"read");

                ?>
        </div>
        <div id="tabs-3">
                <?php

                $WISHLIST = "SELECT * FROM books b LEFT JOIN library l USING(isbn) WHERE l.wishlist = 1 AND user_id = '$user' ORDER BY b.title;";
                lists($WISHLIST,"wishlist");

                ?>
        </div>
</div>
<!-- This div has display turned off in the css above. It's a holder for the jQuery AJAX functions above. -->        
<div id="saver"></div>

</body>
</html>

