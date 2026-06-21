<?php
session_start();
include 'config.php';

if(!isset($_SESSION['user']))
{
    header("Location: login.php");
    exit();
}

$limit = 5;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

$start = ($page - 1) * $limit;

if(isset($_GET['search']) && $_GET['search'] != "")
{
    $search = $_GET['search'];

    $result = mysqli_query($conn,
    "SELECT * FROM posts
    WHERE title LIKE '%$search%'
    OR content LIKE '%$search%'
    ORDER BY id DESC");
}
else
{
    $result = mysqli_query($conn,
    "SELECT * FROM posts
    ORDER BY id DESC
    LIMIT $start,$limit");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Blog Posts</title>
<link rel="stylesheet"
href="assets/css/style.css">
<style>

body{
    font-family: Arial, sans-serif;
    background:#f4f4f4;
    padding:20px;
}

.post{
    background:white;
    padding:15px;
    margin-bottom:15px;
    border-radius:8px;
}

input{
    padding:8px;
}

button{
    padding:8px 12px;
}

</style>

</head>

<body>

<h2>Welcome <?php echo $_SESSION['user']; ?></h2>

<a href="create.php">Create Post</a>
|
<a href="logout.php">Logout</a>

<hr>

<form method="GET">

<input
type="text"
name="search"
placeholder="Search posts">

<button type="submit">
Search
</button>

</form>

<br>

<?php while($row=mysqli_fetch_assoc($result)) { ?>

<div class="post">

<h3><?php echo $row['title']; ?></h3>

<p><?php echo $row['content']; ?></p>

<a href="edit.php?id=<?php echo $row['id']; ?>">
Edit
</a>

|

<a href="delete.php?id=<?php echo $row['id']; ?>">
Delete
</a>

</div>

<?php } ?>

<hr>

<?php

$total_query =
mysqli_query($conn,
"SELECT COUNT(*) as total FROM posts");

$total_row =
mysqli_fetch_assoc($total_query);

$total_pages =
ceil($total_row['total'] / $limit);

for($i=1;$i<=$total_pages;$i++)
{
    echo "<a href='?page=$i'>$i</a> ";
}

?>

</body>
</html>