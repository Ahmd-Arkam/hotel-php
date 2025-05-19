<?php

include 'db.php';

session_start();

$id = $_GET['id'];

 $sql = "DELETE FROM booking WHERE bookingID= $id";
// "DELETE FROM booking WHERE bookingID = $id";

$res = mysqli_query($conn,$sql);

if($res)
{
    $_SESSION['delmsg'] = "Successfuylly Deletd";
    header("Location: booking.php");
    exit();
}
else
{
    $_SESSION['delmsg'] = "Not Deleted";
    header("Location: booking.php");
    exit();
}


?>
