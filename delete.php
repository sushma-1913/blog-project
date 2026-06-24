<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include 'config.php';

if(!isset($_SESSION['user']))
{
    die("Please Login First");
}

if($_SESSION['role'] != 'admin')
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

    if(!$stmt)
    {
        die("Prepare Failed: " . mysqli_error($conn));
    }

    mysqli_stmt_bind_param(
        $stmt,
        "i",
        $id
    );

    if(mysqli_stmt_execute($stmt))
    {
        echo "Post Deleted Successfully";
    }
    else
    {
        echo "Delete Failed";
    }
}
else
{
    echo "No ID Received";
}

?>