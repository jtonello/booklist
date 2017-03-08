<?php
// Note: This file should be placed outside the /booklist directory, ideally renamed as the index.php in the root of your website

// Two user variables, one from the cookie, one from the login form
$user = $_COOKIE['username'];
$username = $_POST['username'];

// This is overly simple and not very secure. Try using the database to manage the credentials.
if($user == "YOUR-USER-NAME-EMAIL") {
        header('Location: booklist/index.php');
} else if($username) {
        setcookie('username', $username, time()+3600);
        header('Location: /index.php');
}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
<!-- This CSS can be stored in a separate file, but it might be easier to edit it here until you're done. -->
<style type="text/css">
        body {
                width: 250px;
                margin: 100px auto;
                font-family: sans-serif;
        }

        div#logon {
                width: 250px;
                height: 80px;
                padding: 10px;
                border: solid 1px #cacaca;
        }

        div#head {
                width: 256px;
                height: 40px;
                padding: 8px;
                background-color: #091d59;
                color: #eee;
                text-align: center;
                font-size: 2em;
        }

        div#logon input[type='text'], div#logon input[type='password'] {
                width: 150px;
                height: 25px;
                padding: 0 3px 0 3px;
                margin: 5px;
        }

</style>

</head>
<body>
<!-- This builds a simple log-in box. -->
        <div id="head">My Library</div>
        <div id="logon">
        <form name="logon" action="/index.php" method="POST">
                <input type="text" name="username" id="username" placeholder="Username" />
                <input type="password" name="password" id="password" placeholder="Password" />
                <input type="submit" value="Go" />
        </form>
        </div>


</body>
</html>

