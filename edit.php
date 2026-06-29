<?php
session_start();
include 'config.php';

if(!isset($_SESSION['user']))
{
    header("Location: login.php");
    exit();
}

$message = "";

if(!isset($_GET['id']))
{
    header("Location: index.php");
    exit();
}

$id = (int)$_GET['id'];

// Get Post Details
$stmt = mysqli_prepare($conn,
"SELECT * FROM posts WHERE id=?");

mysqli_stmt_bind_param($stmt,"i",$id);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$post = mysqli_fetch_assoc($result);

if(!$post)
{
    die("Post not found!");
}

// Update Post
if(isset($_POST['update']))
{
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);

    if(empty($title) || empty($content))
    {
        $message = "All fields are required!";
    }
    else
    {
        $update = mysqli_prepare($conn,
        "UPDATE posts SET title=?, content=? WHERE id=?");

        mysqli_stmt_bind_param(
        $update,
        "ssi",
        $title,
        $content,
        $id
        );

        if(mysqli_stmt_execute($update))
        {
            header("Location: index.php");
            exit();
        }
        else
        {
            $message = "Failed to update post!";
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>

<title>Edit Post</title>

<link rel="stylesheet"
href="assets/css/style.css">

</head>

<body>

<div class="navbar">

<div class="logo">

📝 Blog Management System

</div>

<div class="nav-links">

<a href="dashboard.php">Dashboard</a>

<a href="index.php">Posts</a>

<a href="logout.php">Logout</a>

</div>

</div>

<div class="container">

<div class="card">

<h1>Edit Blog Post</h1>

<p>Update your existing blog post.</p>

</div>

<br>

<form method="POST">

<label>Title</label>

<input
type="text"
name="title"
value="<?php echo htmlspecialchars($post['title']); ?>"
required>

<label>Content</label>

<textarea
name="content"
rows="8"
required><?php echo htmlspecialchars($post['content']); ?></textarea>

<button
class="btn btn-warning"
type="submit"
name="update">

💾 Update Post

</button>

<a
href="index.php"
class="btn btn-secondary">

⬅ Back

</a>

</form>

<?php

if($message!="")
{

?>

<br>

<div class="card">

<h3 style="color:red;">

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