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
    <title>Post Story</title>
</head>
<body>
<?php
if (empty($_POST['title'])) {
    echo("Title cannot be empty!<br>");
}
else{
    $title = $_POST['title'];
}

if (!empty($_POST['link']) && !(filter_var($_POST['link'], FILTER_VALIDATE_URL))) {
    echo("URL is invalid!<br>");
}
else{
    $link = $_POST['link'];
    $link = filter_var($link, FILTER_SANITIZE_URL);
    $body = $_POST['body'];

    $stmt = $mysqli->prepare("insert into stories (title, username, body, link) values (?, ?, ?, ?)");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    
    $stmt->bind_param('ssss', $title, $_SESSION['user'], $body, $link);
    
    $stmt->execute();
    
    $stmt->close();

    header("Location: userPage.php");
} 

?>
  
        
        <form name ="input" action='homePage.php'>
            <input type="submit" value="back to homePage" >
        </form>
        </body>
</html>
