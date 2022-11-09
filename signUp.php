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
    <title>Sign up</title>
</head>
<body>

<?php

$user = $_POST['user'];
$pass = $_POST['password'];

// check for valid username
if( !preg_match('/^[\w_\-]+$/', $user) || $user == ''){
    echo "Username is invalid, please enter again!";
    ?>
    
    <form name ="input" action='login.php'>
        <input type="submit" value="back to login">
    </form>
 
    <?php
    exit; 
}

$stmt = $mysqli->prepare("select count(*) from users where username=?");
if(!$stmt){
	printf("Query Prep count Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('s', $user);

$stmt->execute();

$stmt->bind_result($exist);

if($stmt->fetch())
{
    $stmt->close();
    if($exist >= 1)
    {
        echo "This username is already taken, please choose a new one."; 
        ?> 
        <form name ="input" action='login.php'> 
            <input type="submit" value="back to login" >
        </form>
        <?php
        exit;
    }
    else 
    {
        $_SESSION['user'] = $user;
        $_SESSION['registered'] = true;
        $_SESSION['token'] = bin2hex(random_bytes(32));
        $pwd_hash = password_hash($pass, PASSWORD_DEFAULT);
    
        //insert new user into users table
        $stmt = $mysqli->prepare("insert into users (username, pwd) values (?, ?)");
    
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }
       
        if(!$stmt->bind_param('ss', $user, $pwd_hash))
        {
            printf("Query bind Failed: %s\n", $mysqli->error);
            exit;
        }
    
        if(!$stmt->execute())
        {
            printf("Query execute Failed: %s\n", $mysqli->error);
            exit;
        }
    
        $stmt->close();
    
        header("Location: userPage.php");
    
    }
}




?>