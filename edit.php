<?php
include 'config.php';

$id = $_GET['id'];

$result = mysqli_query($conn,
"SELECT * FROM posts WHERE id=$id");

$row = mysqli_fetch_assoc($result);

if(isset($_POST['update']))
{
    $title = $_POST['title'];
    $content = $_POST['content'];

    mysqli_query($conn,
    "UPDATE posts
     SET title='$title',
         content='$content'
     WHERE id=$id");

    header("Location:index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Post</title>
</head>
<body>

<h2>Edit Post</h2>

<form method="POST">

<input type="text"
       name="title"
       value="<?php echo $row['title']; ?>">

<br><br>

<textarea name="content"
rows="5"
cols="40"><?php echo $row['content']; ?></textarea>

<br><br>

<button type="submit" name="update">
Update
</button>

</form>

</body>
</html>