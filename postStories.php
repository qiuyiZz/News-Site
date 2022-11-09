<?php
session_start();

require 'database.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet" type="text/css">
    <title>Post new Story</title>
</head>
<body>
    <h1>Post a new story</h1>
    <?php

    if(!hash_equals($_SESSION['token'], $_POST['token'])){
        echo "Wrong!";
        die("Request forgery detected");
        
    }

    echo "Author: ". htmlentities($_SESSION['user']) . "<br><br>"; 
    ?>

    <form action="post.php" method="POST">
    <p>
        <label for="title">Title:</label>
        <textarea id="title" name="title" rows="1" cols="50"></textarea>

    </p>

    <p>
        <label for="body">Body:</label>
        <textarea id="body" name="body" rows="10" cols="50"></textarea>
        
    </p>      

    <p>
        <label for="link">Link:</label>
        <textarea id="link" name="link" rows="1" cols="50"></textarea>
        
    </p>


    <input type="submit" class="submitpostButton" value="post">
    
    </form>

    <br>
    
    <form name ="input" action='userPage.php'>
        <input type="submit" value="back to userPage">
    </form>

    <br>
    
    <form name ="input" action='homePage.php'>
        <input type="submit" value="back to homePage">
    </form>
</body>
</html>
