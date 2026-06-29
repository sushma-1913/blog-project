<?php
session_start();
include 'config.php';

if(!isset($_SESSION['user']))
{
    header("Location: login.php");
    exit();
}

// Only Admin Can Delete
if($_SESSION['role'] != "admin")
{
    die("Access Denied! Only Admin can delete posts.");
}

if(isset($_GET['id']))
{
    $id = (int)$_GET['id'];

    $stmt = mysqli_prepare(
    $conn,
    "DELETE FROM posts WHERE id=?"
    );

    mysqli_stmt_bind_param(
    $stmt,
    "i",
    $id
    );

    if(mysqli_stmt_execute($stmt))
    {
        header("Location: index.php?msg=deleted");
        exit();
    }
    else
    {
        echo "Failed to delete post.";
    }
}
else
{
    header("Location: index.php");
    exit();
}
?>