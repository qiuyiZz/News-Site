<?php
session_start();

$_SESSION['registered'] = false;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet" type="text/css">
    <style>
    input[type=submit] {
    width: 100%;
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    }

input[type=submit]:hover {
  background-color: #45a049;
}
</style>
    <title>Login</title>
</head>
<body class="login">
    <div class="main">
    <h2>Login:</h2>
    <form name="input" action="verifyUser.php" method="post">
        Username: <input type="text" name="user">
        <br>
        <br>
        Password: <input type="password" name="password">
        <br>
        <br>
        <input type="submit" value="Login">
    </form>

    <h2>SignUp:</h2>
    <form name="input" action="signUp.php" method="post">
        Username: <input type="text" name="user">
        <br>
        <br>
        Password: <input type="password" name="password">
        <br>
        <br>
        <input type="submit" value="Sign Up">
    </form>
    
    <br>
    <br>

    <form name ="input" action='index.php'>
        <input type="submit" value="Continue as Guest">
    </form>
    </div>
</body>
</html>