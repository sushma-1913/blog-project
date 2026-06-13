<?php
session_start();
include 'config.php';

$message = "";

if(isset($_POST['login']))
{
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users
            WHERE username='$username'";

    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result)==1)
    {
        $user = mysqli_fetch_assoc($result);

        if(password_verify($password,$user['password']))
        {
            $_SESSION['user'] = $username;

            header("Location:index.php");
            exit();
        }
        else
        {
            $message = "Wrong Password";
        }
    }
    else
    {
        $message = "User Not Found";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>

<h2>Login</h2>

<form method="POST">

    Username:
    <input type="text" name="username" required>
    <br><br>

    Password:
    <input type="password" name="password" required>
    <br><br>

    <button type="submit" name="login">
        Login
    </button>

</form>

<p><?php echo $message; ?></p>

<a href="register.php">Register Here</a>

</body>
</html>