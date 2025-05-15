
<?php
session_start();

include 'db.php';

$username = $_POST['username'];
$email = $_POST['email'];

if($_POST['password'] != $_POST['confirmPassword'])
{
    $_SESSION['r-msg'] = "Passwords are not matching!";
    header("Location: user-registration.php");
    exit();
}

$password = password_hash($_POST['password'],PASSWORD_DEFAULT);

$check = mysqli_query($conn,"SELECT * FROM user WHERE email = '$email'");

if(mysqli_num_rows($check) > 0)
{
    $_SESSION['r-msg'] = "Email Already Exists!";
    header("Location: user-registration.php");
    exit();
}

    $sql = "INSERT INTO user(username,email,password) VALUES ('$username','$email','$password')";

    $result = mysqli_query($conn,$sql);

    if($result)
    {
        $_SESSION['r-msg'] = "Succesfully Registered!";
        header("Location: user-registration.php");
        exit();
    }
    else
    {
        $_SESSION['r-msg'] = "Registration Fail!";
        header("Location: user-registration.php");
        exit();
    }



?>