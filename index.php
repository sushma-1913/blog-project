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

if($page < 1)
{
    $page = 1;
}

$start = ($page - 1) * $limit;

if(isset($_GET['search']) && $_GET['search'] != "")
{
    $search = mysqli_real_escape_string($conn,$_GET['search']);

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

$total_query = mysqli_query($conn,
"SELECT COUNT(*) AS total FROM posts");

$total_row = mysqli_fetch_assoc($total_query);

$total_pages = ceil($total_row['total'] / $limit);

?>

<!DOCTYPE html>
<html>

<head>

<title>Blog Posts</title>

<link rel="stylesheet" href="assets/css/style.css">

</head>

<body>

<div class="navbar">

<div class="logo">

📝 Blog Management System

</div>

<div class="nav-links">

<a href="dashboard.php">Dashboard</a>

<a href="create.php">Create Post</a>

<?php
if($_SESSION['role']=="admin")
{
?>

<a href="admin.php">Admin</a>

<?php
}
?>

<a href="logout.php">Logout</a>

</div>

</div>

<div class="container">

<div class="card">

<h1>All Blog Posts</h1>

<p>

Welcome,

<strong>

<?php echo $_SESSION['user']; ?>

</strong>

</p>

</div>

<br>

<form method="GET">

<div class="search-box">

<input
type="text"
name="search"
placeholder="Search by title or content..."
value="<?php if(isset($_GET['search'])) echo htmlspecialchars($_GET['search']); ?>">

<button
class="btn btn-primary"
type="submit">

🔍 Search

</button>

</div>

</form>

<br>

<?php

if(mysqli_num_rows($result)>0)
{

while($row=mysqli_fetch_assoc($result))
{

?>

<div class="post">

<h2>

<?php echo htmlspecialchars($row['title']); ?>

</h2>

<br>

<p>

<?php

echo nl2br(htmlspecialchars($row['content']));

?>

</p>

<br>

<a
class="btn btn-warning"
href="edit.php?id=<?php echo $row['id']; ?>">

✏ Edit

</a>

<?php

if($_SESSION['role']=="admin")
{

?>

<a
class="btn btn-danger"
href="delete.php?id=<?php echo $row['id']; ?>"
onclick="return confirm('Delete this post?');">

🗑 Delete

</a>

<?php

}

?>

</div>

<?php

}

}

else

{

?>

<div class="card">

<h3>No Posts Found.</h3>

</div>

<?php

}

?>

<div class="pagination">

<?php

for($i=1;$i<=$total_pages;$i++)
{

echo "<a href='?page=$i'>$i</a>";

}

?>

</div>

</div>

<div class="footer">

© <?php echo date("Y"); ?>

Blog Management System

</div>

</body>

</html>