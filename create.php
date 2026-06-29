<?php
session_start();
include 'config.php';

if(!isset($_SESSION['user']))
{
    header("Location: login.php");
    exit();
}

$message="";

if(isset($_POST['submit']))
{
    $title=trim($_POST['title']);
    $content=trim($_POST['content']);

    if(empty($title) || empty($content))
    {
        $message="All fields are required!";
    }
    else
    {
        $stmt=mysqli_prepare(
        $conn,
        "INSERT INTO posts(title,content) VALUES(?,?)"
        );

        mysqli_stmt_bind_param(
        $stmt,
        "ss",
        $title,
        $content
        );

        if(mysqli_stmt_execute($stmt))
        {
            $message="Post Added Successfully!";
        }
        else
        {
            $message="Something went wrong!";
        }
    }
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

<div class="navbar">

<div class="logo">

📝 Blog Management System

</div>

<div class="nav-links">

<a href="dashboard.php">

Dashboard

</a>

<a href="index.php">

Posts

</a>

<a href="logout.php">

Logout

</a>

</div>

</div>

<div class="container">

<div class="card">

<h1>Create New Post</h1>

<p>Create and publish your blog post.</p>

</div>

<br>

<form method="POST">

<label>

Title

</label>

<input
type="text"
name="title"
placeholder="Enter post title..."
required>

<label>

Content

</label>

<textarea
name="content"
rows="8"
placeholder="Write your content here..."
required>

</textarea>

<button
class="btn btn-success"
type="submit"
name="submit">

➕ Publish Post

</button>

<a
href="dashboard.php"
class="btn btn-secondary">

🏠 Dashboard

</a>

</form>

<?php

if($message!="")
{

?>

<br>

<div class="card">

<h3 style="color:green;">

<?php echo $message; ?>

</h3>

</div>

<?php

}

?>

</div>

<div class="footer">

© <?php echo date("Y"); ?>

Blog Management System

</div>

</body>

</html>