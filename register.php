<?php
include 'config.php';

$message = "";

if(isset($_POST['register']))
{
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if(empty($username) || empty($password))
    {
        $message = "All fields are required";
    }
    elseif(strlen($password) < 6)
    {
        $message = "Password must be at least 6 characters";
    }
    else
    {
        $hashedPassword =
        password_hash($password, PASSWORD_DEFAULT);

        $stmt = mysqli_prepare(
        $conn,
        "INSERT INTO users(username,password)
        VALUES(?,?)"
        );

        mysqli_stmt_bind_param(
        $stmt,
        "ss",
        $username,
        $hashedPassword
        );

        if(mysqli_stmt_execute($stmt))
        {
            $message = "Registration Successful!";
        }
        else
        {
            $message = "Error!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<h2>User Registration</h2>

<form method="POST">

    Username:
    <input type="text" name="username" required>
    <br><br>

    Password:
    <input type="password" name="password" required>
    <br><br>

    <button type="submit" name="register">
        Register
    </button>

</form>

<p><?php echo $message; ?></p>

<a href="login.php">Login Here</a>

</body>
</html>