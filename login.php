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
        $message = "All fields are required";
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

        if(mysqli_num_rows($result) == 1)
        {
            $user = mysqli_fetch_assoc($result);

            if(password_verify($password, $user['password']))
            {
                $_SESSION['user'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                header("Location: dashboard.php");
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
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>

    <style>
    body{
        font-family: Arial, sans-serif;
        background:#f4f6f9;
        margin:0;
        padding:0;
    }

    .login-box{
        width:400px;
        background:white;
        margin:100px auto;
        padding:30px;
        border-radius:15px;
        box-shadow:0px 0px 20px rgba(0,0,0,0.2);
    }

    h2{
        text-align:center;
    }

    input{
        width:100%;
        padding:12px;
        margin-top:5px;
        margin-bottom:15px;
        box-sizing:border-box;
    }

    button{
        width:100%;
        padding:12px;
        background:#007bff;
        color:white;
        border:none;
        border-radius:8px;
        cursor:pointer;
    }

    button:hover{
        background:#0056b3;
    }

    .message{
        text-align:center;
        color:red;
    }

    .link{
        text-align:center;
        margin-top:15px;
    }
    </style>

</head>
<body>

<div class="login-box">

    <h2>Login</h2>

    <form method="POST">

        Username:
        <input type="text" name="username" required>

        Password:
        <input type="password" name="password" required>

        <button type="submit" name="login">
            Login
        </button>

    </form>

    <p class="message"><?php echo $message; ?></p>

    <div class="link">
        <a href="register.php">Register Here</a>
    </div>

</div>

</body>
</html>