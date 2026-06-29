<?php
include 'config.php';

$message = "";

if(isset($_POST['register']))
{
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = "editor";

    if(empty($username) || empty($password))
    {
        $message = "All fields are required!";
    }
    elseif(strlen($password) < 6)
    {
        $message = "Password must be at least 6 characters!";
    }
    else
    {
        $check = mysqli_prepare(
            $conn,
            "SELECT id FROM users WHERE username=?"
        );

        mysqli_stmt_bind_param(
            $check,
            "s",
            $username
        );

        mysqli_stmt_execute($check);

        $result = mysqli_stmt_get_result($check);

        if(mysqli_num_rows($result) > 0)
        {
            $message = "Username already exists!";
        }
        else
        {
            $hashedPassword = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            $stmt = mysqli_prepare(
                $conn,
                "INSERT INTO users(username,password,role)
                VALUES(?,?,?)"
            );

            mysqli_stmt_bind_param(
                $stmt,
                "sss",
                $username,
                $hashedPassword,
                $role
            );

            if(mysqli_stmt_execute($stmt))
            {
                $message = "Registration Successful!";
            }
            else
            {
                $message = "Registration Failed!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Register</title>

<link
rel="stylesheet"
href="assets/css/style.css">

</head>

<body>

<nav class="navbar">

<div class="logo">

📝 Blog Management System

</div>

<div class="nav-links">

<a href="login.php">

Login

</a>

</div>

</nav>

<div class="auth-box">

<h2>Create Account</h2>

<p class="subtitle">

Create your account to continue.

</p>

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
type="submit"
name="register"
class="btn btn-success">

📝 Register

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

<div class="bottom-link">

Already have an account?

<br><br>

<a
href="login.php"
class="btn btn-primary">

🔑 Login

</a>

</div>

</div>

<footer class="footer">

© <?php echo date("Y"); ?>

Blog Management System

</footer>

</body>

</html>