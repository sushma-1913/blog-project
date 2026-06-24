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

    <a href="create.php" class="btn">
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