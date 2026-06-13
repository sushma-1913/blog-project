<?php
session_start();
include 'config.php';

if(!isset($_SESSION['user']))
{
    header("Location: login.php");
    exit();
}

$result = mysqli_query($conn,
"SELECT * FROM posts ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Blog Posts</title>
</head>
<body>

<h2>Welcome <?php echo $_SESSION['user']; ?></h2>

<a href="create.php">Create Post</a>
|
<a href="logout.php">Logout</a>

<hr>

<?php while($row=mysqli_fetch_assoc($result)) { ?>

<h3><?php echo $row['title']; ?></h3>

<p><?php echo $row['content']; ?></p>

<a href="edit.php?id=<?php echo $row['id']; ?>">
Edit
</a>

|

<a href="delete.php?id=<?php echo $row['id']; ?>">
Delete
</a>

<hr>

<?php } ?>

</body>
</html>