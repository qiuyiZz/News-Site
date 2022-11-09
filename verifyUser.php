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
    <title>Verify User</title>
</head>
<body>

<?php
$user = $_POST['user'];
$pwd = $_POST['password'];

// verify username
if( !preg_match('/^[\w_\-]+$/', $user) || $user == ''){
    echo "Username is invalid, please try again!";
    ?>
    
    <form name ="input" action='login.php'>
        <input type="submit" value="back to login" />
    </form>
 
    <?php
    exit; 
}
else {
    echo "valid username";
}


$stmt = $mysqli->prepare("select count(*), pwd from users where username=?");

$stmt->bind_param('s', $user);

$stmt->execute();

$stmt->bind_result($exist, $pwd_hash);
$stmt->fetch();

// verify password
if($exist == 1 && password_verify($pwd, $pwd_hash)){

	$_SESSION['user'] = $_POST['user'];
    $_SESSION['registered'] = true;
    $_SESSION['token'] = bin2hex(random_bytes(32));

    header("Location: userPage.php");
} else{
    echo "Wrong password!";
    header("Location: login.php");
}
?>

</body>
</html>
