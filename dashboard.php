<?php
session_start();

if(!isset($_SESSION['user']))
{
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>

    <style>

    body{
        font-family: Arial, sans-serif;
        background:#f4f6f9;
        margin:0;
        padding:0;
    }

    .dashboard{
        width:450px;
        background:white;
        margin:80px auto;
        padding:30px;
        text-align:center;
        border-radius:15px;
        box-shadow:0px 0px 20px rgba(0,0,0,0.2);
    }

    h1{
        color:#333;
        margin-bottom:20px;
    }

    .welcome,
    .role{
        font-size:18px;
        color:#555;
    }

    .btn{
        display:block;
        width:250px;
        margin:15px auto;
        padding:15px;
        background:#007bff;
        color:white;
        text-decoration:none;
        border-radius:10px;
        font-size:16px;
        font-weight:bold;
        transition:0.3s;
    }

    .btn:hover{
        background:#0056b3;
        transform:scale(1.05);
    }

    .logout{
        background:#dc3545;
    }

    .logout:hover{
        background:#b02a37;
    }

    .admin{
        background:#28a745;
    }

    .admin:hover{
        background:#1e7e34;
    }

    </style>

</head>
<body>

<div class="dashboard">

    <h1>Dashboard</h1>

    <p class="welcome">
        Welcome, <b><?php echo $_SESSION['user']; ?></b>
    </p>

    <p class="role">
        Role: <b><?php echo ucfirst($_SESSION['role']); ?></b>
    </p>

    <hr>

    <a href="create.php" class="btn"><?php
session_start();
include 'config.php';

if(!isset($_SESSION['user']))
{
    header("Location: login.php");
    exit();
}

// Total Posts
$postQuery = mysqli_query($conn, "SELECT COUNT(*) AS total_posts FROM posts");
$postData = mysqli_fetch_assoc($postQuery);

// Total Users
$userQuery = mysqli_query($conn, "SELECT COUNT(*) AS total_users FROM users");
$userData = mysqli_fetch_assoc($userQuery);

// Latest 5 Posts
$recentPosts = mysqli_query($conn,
"SELECT * FROM posts ORDER BY id DESC LIMIT 5");
?>

<!DOCTYPE html>
<html>
<head>

    <title>Dashboard</title>

    <link rel="stylesheet" href="assets/css/style.css">

</head>

<body>

<!-- Navbar -->

<div class="navbar">

    <div class="logo">
        📝 Blog Management System
    </div>

    <div class="nav-links">

        <a href="dashboard.php">Dashboard</a>

        <a href="index.php">Posts</a>

        <a href="create.php">Create</a>

        <?php if($_SESSION['role']=="admin"){ ?>

        <a href="admin.php">Admin</a>

        <?php } ?>

        <a href="logout.php">Logout</a>

    </div>

</div>

<!-- Dashboard -->

<div class="dashboard">

    <h1>Welcome, <?php echo $_SESSION['user']; ?> 👋</h1>

    <p>
        Role :
        <strong style="color:#0d6efd;">
            <?php echo ucfirst($_SESSION['role']); ?>
        </strong>
    </p>

    <!-- Statistics -->

    <div class="stats">

        <div class="stat-card">

            <h2>
                <?php echo $postData['total_posts']; ?>
            </h2>

            <p>Total Posts</p>

        </div>

        <div class="stat-card">

            <h2>
                <?php echo $userData['total_users']; ?>
            </h2>

            <p>Total Users</p>

        </div>

        <div class="stat-card">

            <h2>🔒</h2>

            <p>Security Enabled</p>

        </div>

    </div>

    <!-- Quick Actions -->

    <div class="card">

        <h2>Quick Actions</h2>

        <br>

        <a href="create.php" class="btn btn-success">
            ➕ Create Post
        </a>

        <a href="index.php" class="btn btn-primary">
            📄 View Posts
        </a>

        <?php if($_SESSION['role']=="admin"){ ?>

        <a href="admin.php" class="btn btn-warning">
            👑 Admin Panel
        </a>

        <?php } ?>

        <a href="logout.php" class="btn btn-danger">
            🚪 Logout
        </a>

    </div>

    <br>

    <!-- Recent Posts -->

    <div class="card">

        <h2>Recent Posts</h2>

        <br>

        <?php

        if(mysqli_num_rows($recentPosts)>0)
        {

            while($row=mysqli_fetch_assoc($recentPosts))
            {
        ?>

            <div class="post">

                <h3>

                    <?php echo htmlspecialchars($row['title']); ?>

                </h3>

                <p>

                    <?php

                    echo nl2br(htmlspecialchars(substr($row['content'],0,120)));

                    ?>

                </p>

                <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">
                    ✏ Edit
                </a>

                <?php if($_SESSION['role']=="admin"){ ?>

                <a href="delete.php?id=<?php echo $row['id']; ?>"
                class="btn btn-danger"
                onclick="return confirm('Are you sure you want to delete this post?');">
                    🗑 Delete
                </a>

                <?php } ?>

            </div>

        <?php

            }

        }

        else
        {

            echo "<p>No posts available.</p>";

        }

        ?>

    </div>

</div>

<div class="footer">

    © <?php echo date("Y"); ?>

    Blog Management System |

    Developed by <?php echo $_SESSION['user']; ?>

</div>

</body>
</html>
        ➕ Create Post
    </a>

    <a href="index.php" class="btn">
        📄 View Posts
    </a>

    <?php if($_SESSION['role'] == 'admin') { ?>

    <a href="#" class="btn admin">
        👑 Admin Panel
    </a>

    <?php } ?>

    <a href="logout.php" class="btn logout">
        🚪 Logout
    </a>

</div>

</body>
</html>