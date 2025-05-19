<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}
include 'db.php';

$id = $_GET['id'];
$res = mysqli_query($conn, "SELECT * FROM booking WHERE bookingID='$id'");
$result = mysqli_fetch_assoc($res);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --color-white: #fff;
            --color-black: #000;
            --color-light-gray: #bbb;
            --color-mid-gray: #555;
            --color-dark-gray: #222;
            --color-shadow: rgba(255,255,255, 0.15);
        }
        
        body {
            background-color: var(--color-black);
            color: var(--color-white);
            font-family: 'Roboto', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }
        
        .booking-form {
            background-color: var(--color-dark-gray);
            border-radius: 8px;
            padding: 30px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 4px 20px var(--color-shadow);
            border: 1px solid var(--color-mid-gray);
        }
        
        .form-title {
            color: var(--color-white);
            text-align: center;
            margin-bottom: 25px;
            font-weight: 700;
            font-size: 1.5rem;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-label {
            color: var(--color-white);
            font-weight: 500;
            margin-bottom: 8px;
            display: block;
        }
        
        .form-control, .form-select {
            background-color: var(--color-black);
            border: 1px solid var(--color-mid-gray);
            color: var(--color-white);
            padding: 10px 15px;
            border-radius: 4px;
            width: 100%;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--color-light-gray);
            outline: none;
            box-shadow: none;
        }
        
        .btn-submit {
            background-color: var(--color-mid-gray);
            color: var(--color-white);
            border: none;
            padding: 10px 0;
            font-weight: 600;
            border-radius: 4px;
            width: 100%;
            margin-top: 10px;
            cursor: pointer;
        }
        
        .btn-submit:hover {
            background-color: var(--color-light-gray);
        }
    </style>
</head>
<body>
<div class="booking-form">
    <h2 class="form-title">UPDATE BOOKING</h2>

    <form action="update.php" method="POST">
        <input type="hidden" name="bookingID" value="<?= $result['bookingID']; ?>">

        <div class="form-group">
            <label class="form-label">Guest Name</label>
            <input type="text" class="form-control" name="guestName" 
                   value="<?= htmlspecialchars($result['guestName']); ?>" required>
        </div>

        <div class="form-group">
            <label class="form-label">Room</label>
            <select class="form-select" name="roomNumber" required>
                <option value="">Select Room</option>
                <option value="101" <?= ($result['roomNumber'] == '101') ? 'selected' : ''; ?>>Room 101</option>
                <option value="102" <?= ($result['roomNumber'] == '102') ? 'selected' : ''; ?>>Room 102</option>
                <option value="201" <?= ($result['roomNumber'] == '201') ? 'selected' : ''; ?>>Room 201</option>
                <option value="202" <?= ($result['roomNumber'] == '202') ? 'selected' : ''; ?>>Room 202</option>
            </select>
        </div>

        <div class="form-group">
            <label class="form-label">Booking Date</label>
            <input type="date" class="form-control" name="date" 
                   value="<?= htmlspecialchars($result['date']); ?>" required>
        </div>

        <div class="form-group">
            <label class="form-label">Status</label>
            <select class="form-select" name="status" required>
                <option value="Confirmed" <?= ($result['status'] == 'Confirmed') ? 'selected' : ''; ?>>Confirmed</option>
                <option value="Pending" <?= ($result['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                <option value="Cancelled" <?= ($result['status'] == 'Cancelled') ? 'selected' : ''; ?>>Cancelled</option>
            </select>
        </div>

        <button type="submit" class="btn-submit">UPDATE</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>