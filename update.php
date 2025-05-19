<?php
include 'db.php';
session_start();

// Get form data
$bookingID = $_POST['bookingID'];
$guestName = mysqli_real_escape_string($conn, $_POST['guestName']);
$roomNumber = mysqli_real_escape_string($conn, $_POST['roomNumber']);
$date = mysqli_real_escape_string($conn, $_POST['date']);
$status = mysqli_real_escape_string($conn, $_POST['status']);

// Update query for booking
$sql = "UPDATE booking SET 
        guestName = '$guestName', 
        roomNumber = '$roomNumber', 
        date = '$date', 
        status = '$status' 
        WHERE bookingID = '$bookingID'";

$res = mysqli_query($conn, $sql);

if($res) {
    $_SESSION['msg'] = "Booking successfully updated";
    header("Location: booking.php");
    exit();
} else {
    $_SESSION['msg'] = "Error updating booking: " . mysqli_error($conn);
    header("Location: bookupdate.php?id=$bookingID"); // Redirect back to update form with error
    exit();
}
?>