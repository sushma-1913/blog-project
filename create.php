<?php
session_start();
include 'config.php';

if(!isset($_SESSION['user']))
{
    header("Location: login.php");
    exit();
}

if(isset($_POST['submit']))
{
    $title = $_POST['title'];
    $content = $_POST['content'];

    $sql = "INSERT INTO posts(title,content)
            VALUES('$title','$content')";

    mysqli_query($conn,$sql);

    header("Location:index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Post</title>
    <link rel="stylesheet"
href="assets/css/style.css">
</head>
<body>

<h2>Create Post</h2>

<form method="POST">

Title:
<input type="text" name="title" required>
<br><br>

Content:
<br>
<textarea name="content" rows="5" cols="40" required></textarea>
<br><br>

<button type="submit" name="submit">
Add Post
</button>

</form>

</body>
</html>