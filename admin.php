<?php
session_start();
include 'config.php';

if(!isset($_SESSION['user']))
{
    header("Location: login.php");
    exit();
}

if($_SESSION['role'] != "admin")
{
    die("Access Denied! Admin Only.");
}

// Total Users
$userResult = mysqli_query($conn,
"SELECT COUNT(*) AS total_users FROM users");

$userCount = mysqli_fetch_assoc($userResult);

// Total Posts
$postResult = mysqli_query($conn,
"SELECT COUNT(*) AS total_posts FROM posts");

$postCount = mysqli_fetch_assoc($postResult);

// All Users
$users = mysqli_query($conn,
"SELECT * FROM users ORDER BY id DESC");

// All Posts
$posts = mysqli_query($conn,
"SELECT * FROM posts ORDER BY id DESC");

?>

<!DOCTYPE html>
<html>

<head>

<title>Admin Panel</title>

<link rel="stylesheet"
href="assets/css/style.css">

</head>

<body>

<div class="navbar">

<div class="logo">

👑 Admin Panel

</div>

<div class="nav-links">

<a href="dashboard.php">Dashboard</a>

<a href="index.php">Posts</a>

<a href="logout.php">Logout</a>

</div>

</div>

<div class="container">

<h1 style="margin-bottom:20px;">

Welcome Admin,
<?php echo $_SESSION['user']; ?>

</h1>

<div class="stats">

<div class="stat-card">

<h2>

<?php echo $userCount['total_users']; ?>

</h2>

<p>Total Users</p>

</div>

<div class="stat-card">

<h2>

<?php echo $postCount['total_posts']; ?>

</h2>

<p>Total Posts</p>

</div>

<div class="stat-card">

<h2>

🛡

</h2>

<p>Admin Access</p>

</div>

</div>

<br>

<div class="card">

<h2>Registered Users</h2>

<br>

<table>

<tr>

<th>ID</th>

<th>Username</th>

<th>Role</th>

</tr>

<?php

while($row=mysqli_fetch_assoc($users))
{

?>

<tr>

<td>

<?php echo $row['id']; ?>

</td>

<td>

<?php echo htmlspecialchars($row['username']); ?>

</td>

<td>

<?php echo ucfirst($row['role']); ?>

</td>

</tr>

<?php

}

?>

</table>

</div>

<br>

<div class="card">

<h2>All Blog Posts</h2>

<br>

<table>

<tr>

<th>ID</th>

<th>Title</th>

<th>Content</th>

</tr>

<?php

while($row=mysqli_fetch_assoc($posts))
{

?>

<tr>

<td>

<?php echo $row['id']; ?>

</td>

<td>

<?php echo htmlspecialchars($row['title']); ?>

</td>

<td>

<?php echo substr(htmlspecialchars($row['content']),0,80); ?>

...</td>

</tr>

<?php

}

?>

</table>

</div>

<br>

<center>

<a href="dashboard.php"

class="btn btn-primary">

🏠 Back to Dashboard

</a>

</center>

</div>

<div class="footer">

© <?php echo date("Y"); ?>

Blog Management System

</div>

</body>

</html>