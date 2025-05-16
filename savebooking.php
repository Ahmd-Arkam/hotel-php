<?php

session_start();

include 'db.php';

$guestName = $_POST['guestName'];
$roomNumber = $_POST['roomNumber'];
$date = $_POST['date'];
$status = $_POST['status'];

$sql = "INSERT INTO booking(guestName,roomNumber,date,status) VALUES ('$guestName','$roomNumber','$date','status')";
$res = mysqli_query($conn,$sql);
if($res)
{
    // echo "Saved Successfully";
    $_SESSION['msg'] = "Saved Successfully";
    header("Location: booking.php");
    exit();
}
else
{
    // echo "Sorry, The Data is not registered";
    $_SESSION['msg'] = "Not Saved, Error in Saving The Data";
    header("Location: booking.php");
    exit();
}
?>