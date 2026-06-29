<?php
session_start();
include 'config.php';

$message = "";

if(isset($_POST['login']))
{
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if(empty($username) || empty($password))
    {
        $message = "All fields are required!";
    }
    else
    {
        $stmt = mysqli_prepare(
        $conn,
        "SELECT * FROM users WHERE username=?"
        );

        mysqli_stmt_bind_param(
        $stmt,
        "s",
        $username
        );

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if(mysqli_num_rows($result)==1)
        {
            $user = mysqli_fetch_assoc($result);

            if(password_verify($password,$user['password']))
            {
                $_SESSION['user'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                header("Location: dashboard.php");
                exit();
            }
            else
            {
                $message = "Incorrect Password!";
            }
        }
        else
        {
            $message = "Username not found!";
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>

<title>Login</title>

<link rel="stylesheet"
href="assets/css/style.css">

</head>

<body>

<div class="navbar">

<div class="logo">

📝 Blog Management System

</div>

<div class="nav-links">

<a href="register.php">

Register

</a>

</div>

</div>

<div class="auth-box">

<h2>

Welcome Back 👋

</h2>

<p style="text-align:center;color:gray;">

Login to continue

</p>

<br>

<form method="POST">

<label>

Username

</label>

<input
type="text"
name="username"
placeholder="Enter Username"
required>

<label>

Password

</label>

<input
type="password"
name="password"
placeholder="Enter Password"
required>

<button
class="btn btn-primary"
type="submit"
name="login">

🔑 Login

</button>

</form>

<?php

if($message!="")
{

?>

<p class="message">

<?php echo $message; ?>

</p>

<?php

}

?>

<div style="text-align:center;margin-top:20px;">

Don't have an account?

<br><br>

<a
class="btn btn-success"
href="register.php">

📝 Register

</a>

</div>

</div>

<div class="footer">

© <?php echo date("Y"); ?>

Blog Management System

</div>

</body>

</html>