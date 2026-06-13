<?php
include 'config.php';

$message = "";

if(isset($_POST['register']))
{
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users(username,password)
            VALUES('$username','$password')";

    if(mysqli_query($conn,$sql))
    {
        $message = "Registration Successful!";
    }
    else
    {
        $message = "Error!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
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