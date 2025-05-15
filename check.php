<?php

include 'db.php';
session_start();

$email = $_POST['email'];
$password = $_POST['password'];

$res = mysqli_query($conn,"SELECT * FROM user WHERE email = '$email'");

if(mysqli_num_rows($res) == 1)
{
    $row = mysqli_fetch_assoc($res);
    if(password_verify($password,$row['password']))
    {
        $_SESSION['user'] = $row['username'];
        header("Location: dashboard.php");
        exit();
    }
    else
    {
        $_SESSION['msg'] = "Password is incorrect";
        header("Location: login.php");
        exit();
    }
}
else
{
    $_SESSION['msg'] = "Email is Invalid";
        header("Location: login.php");
        exit();
}

?>