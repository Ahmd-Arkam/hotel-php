<?php

session_start();
if(!isset($_SESSION['user']))
{
    header("Location: login.php");
    exit();
}
include 'db.php';
$result = mysqli_query($conn, "SELECT * FROM booking");

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Hotel Management Dashboard - Black & White Theme</title>
 <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
  @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

  /* Reset and base */
  * {
    box-sizing: border-box;
  }
  body, html {
    margin: 0; padding: 0; height: 100%;
    font-family: 'Roboto', sans-serif;
    background-color: #000;
    color: #eee;
    overflow: hidden;
  }
  :root {
    --color-white: #fff;
    --color-black: #000;
    --color-light-gray: #bbb;
    --color-mid-gray: #555;
    --color-dark-gray: #222;
    --color-shadow: rgba(255,255,255, 0.15);
  }

  #app {
    display: flex;
    height: 100vh;
    width: 100vw;
  }

  /* Sidebar */
  nav {
    background-color: var(--color-black);
    width: 200px;
    display: flex;
    flex-direction: column;
    padding: 30px 20px;
    box-shadow: 2px 0 8px var(--color-shadow);
  }
  nav .logo {
    font-weight: 700;
    font-size: 24px;
    letter-spacing: 3px;
    user-select: none;
    margin-bottom: 40px;
    color: var(--color-white);
    text-align: center;
  }
  nav .nav-item {
    padding: 15px 20px;
    color: var(--color-white);
    font-weight: 600;
    font-size: 16px;
    margin-bottom: 12px;
    border-radius: 8px;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 12px;
    transition: background-color 0.3s ease, color 0.3s ease;
    user-select: none;
  }
  nav .nav-item:hover,
  nav .nav-item.active {
    background-color: var(--color-dark-gray);
    color: var(--color-white);
  }
  nav .nav-item svg {
    fill: currentColor;
    width: 24px;
    height: 24px;
    transition: fill 0.3s ease;
  }

  /* Main content */
  main {
    background-color: var(--color-dark-gray);
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    padding: 20px 40px 30px 40px;
    overflow-y: auto;
    -webkit-overflow-scrolling: touch;
  }
  main header.main-header {
    font-size: 32px;
    font-weight: 700;
    margin: 0;
    user-select: none;
    color: var(--color-white);
  }

  /* Top bar with notification and user profile */
  .top-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    user-select: none;
  }
  .top-bar .page-title {
    font-size: 28px;
    font-weight: 700;
    color: var(--color-white);
  }
  .top-bar .right-controls {
    display: flex;
    align-items: center;
    gap: 24px;
  }
  /* Notification Icon */
  .notification {
    position: relative;
    cursor: pointer;
    color: var(--color-white);
    width: 28px;
    height: 28px;
    flex-shrink: 0;
    transition: color 0.3s ease;
  }
  .notification:hover {
    color: var(--color-light-gray);
  }
  .notification svg {
    width: 28px;
    height: 28px;
    fill: currentColor;
  }
  .notification .badge {
    position: absolute;
    top: -4px;
    right: -4px;
    background-color: var(--color-light-gray);
    color: var(--color-black);
    font-size: 12px;
    font-weight: 700;
    line-height: 1;
    border-radius: 50%;
    padding: 3px 6px;
    min-width: 18px;
    text-align: center;
    user-select: none;
  }

  /* User Profile */
  .user-profile {
    display: flex;
    align-items: center;
    gap: 12px;
    cursor: pointer;
    color: var(--color-white);
    transition: color 0.3s ease;
  }
  .user-profile:hover {
    color: var(--color-light-gray);
  }
  .user-avatar {
    width: 36px;
    height: 36px;
    background-color: var(--color-white);
    border-radius: 50%;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    color: var(--color-black);
    font-size: 18px;
    user-select: none;
  }
  .user-name {
    font-weight: 600;
    font-size: 16px;
  }

  /* Cards grid */
  .cards {
    margin-top:70px;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
  }

  /* Card styling */
  .card {
    background: var(--color-white);
    color: var(--color-black);
    border-radius: 16px;
    padding: 25px 30px 35px 30px;
    box-shadow: 0 6px 20px var(--color-shadow);
    display: flex;
    flex-direction: column;
    user-select: none;
  }
  .card h2 {
    font-size: 24px;
    font-weight: 700;
    margin: 0 0 18px 0;
  }
  .card .value {
    font-size: 40px;
    font-weight: 700;
    line-height: 1;
  }
  .card .subtitle {
    font-size: 14px;
    color: var(--color-mid-gray);
    margin-top: 8px;
  }

  /* Full width cards for charts */
  .booking-view-card {
    grid-column: 1 / -1;
  }

  /* Room status list */
  .room-status {
    display: flex;
    flex-direction: column;
    gap: 14px;
    font-size: 16px;
    font-weight: 600;
  }
  .room-status-item {
    display: flex;
    justify-content: space-between;
  }
   /* Logout Button */
  .logout-btn {
    background-color: var(--color-accent);
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 6px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 8px;
  }
  .logout-btn:hover {
    background-color: #ff6b81;
    transform: translateY(-1px);
  }
  .logout-btn:active {
    transform: translateY(0);
  }
  .logout-btn svg {
    width: 16px;
    height: 16px;
    fill: currentColor;
  }


  /* Chart canvas */
  canvas {
    width: 100% !important;
    height: 280px !important;
    user-select: none;
  }

  /* Scrollbar styling for main content */
  main::-webkit-scrollbar {
    width: 10px;
  }
  main::-webkit-scrollbar-thumb {
    background-color: var(--color-light-gray);
    border-radius: 6px;
  }
  main::-webkit-scrollbar-track {
    background-color: transparent;
  }
    /* Booking Table */
  .booking-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
  }
  .booking-table th, .booking-table td {
    border: 1px solid #ccc;
    padding: 12px;
    text-align: left;
    background-color: #fff;
    color: #000;
  }
  .booking-table th {
    background-color: #eee;
    font-weight: 700;
  }

  .btn {
    background-color: #222;
    color: #fff;
    padding: 10px 18px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
    margin-top: 20px;
  }
  .btn:hover {
    background-color: #444;
  }

  /* Modal */
  .modal {
    display: none;
    position: fixed;
    z-index: 10;
    left: 0; top: 0;
    width: 100vw; height: 100vh;
    background-color: rgba(0,0,0,0.6);
    align-items: center;
    justify-content: center;
  }

  .modal-content {
    background-color: #fff;
    padding: 25px 30px;
    border-radius: 10px;
    width: 90%;
    max-width: 500px;
    color: #000;
    position: relative;
  }

  .modal-content h3 {
    margin-top: 0;
    margin-bottom: 20px;
  }

  .modal-content label {
    display: block;
    margin-bottom: 6px;
    font-weight: 600;
  }

  .modal-content input, .modal-content select {
    width: 100%;
    padding: 10px;
    margin-bottom: 14px;
    border: 1px solid #ccc;
    border-radius: 6px;
  }

  .close-btn {
    position: absolute;
    top: 10px; right: 15px;
    background: none;
    border: none;
    font-size: 20px;
    cursor: pointer;
    color: #333;
  }

  .submit-btn {
    background-color: #000;
    color: #fff;
    padding: 10px 16px;
    border: none;
    border-radius: 6px;
    font-weight: 600;
    cursor: pointer;
  }

  .submit-btn:hover {
    background-color: #444;
  }

  /* Responsive adjustments */
  @media (max-width: 900px) {
    .cards {
      grid-template-columns: 1fr 1fr;
    }
    main {
      padding: 20px 25px;
    }
    nav {
      width: 140px;
      padding: 25px 15px;
    }
    nav .logo {
      font-size: 20px;
      margin-bottom: 30px;
    }
    nav .nav-item {
      font-size: 14px;
      padding: 12px 15px;
      gap: 8px;
    }
    canvas {
      height: 220px !important;
    }
    .logout-btn {
      padding: 6px 12px;
      font-size: 14px;
    }
  
  }

  @media (max-width: 600px) {
    #app {
      flex-direction: column;
      height: auto;
    }
    nav {
      width: 100%;
      flex-direction: row;
      justify-content: center;
      padding: 15px 0;
      box-shadow: 0 2px 8px var(--color-shadow);
    }
    nav .logo {
      display: none;
    }
    nav .nav-item {
      margin: 0 12px;
      padding: 12px 0;
      border-radius: 6px;
      font-size: 14px;
    }
    main {
      padding: 20px 15px;
      height: auto;
      overflow: visible;
    }
    .cards {
      grid-template-columns: 1fr;
      gap: 20px;
    }
    canvas {
      height: 200px !important;
    }
  }
</style>
</head>
<body>
<div id="app" role="main" aria-label="Hotel Management Dashboard">
  <nav role="navigation" aria-label="Sidebar Navigation">
    <div class="logo" aria-label="Hotel Dashboard Logo">HOTEL DASHBOARD</div>

    <div class="nav-item " title="Dashboard" aria-current="page" tabindex="0">
      <!-- Home icon -->
      <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg>
      <span><a href="dashboard.php" style="text-decoration:none; color:white;">Dashboard</a></span>
    </div>
    <div class="nav-item active" title="Bookings" tabindex="0">
      <!-- Bookings icon -->
      <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M3 13h2v-2H3v2zm0-4h2V7H3v2zm0 8h2v-2H3v2zm4 0h14v-2H7v2zm0-4h14v-2H7v2zm0-6v2h14V7H7z"/></svg>
      <span><a href="booking.php" style="text-decoration:none; color:white;">Bookings</a></span>
    </div>
    <!-- <div class="nav-item" title="Rooms" tabindex="0"> -->
<!-- Rooms icon -->
      <!-- <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M7 14h10v-4H7v4zm12-11H5c-1.1 0-2 .9-2 2v3h2V5h14v14h-4v2h4c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z"/></svg>
      <span><a href="" style="text-decoration:none; color:white;">Rooms</a></span>
    </div>
    <div class="nav-item" title="Reports" tabindex="0"> -->
<!-- Reports icon -->
      <!-- <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M3 13h2v-2H3v2zm0-4h2V7H3v2zm0 8h2v-2H3v2zm4 0h14v-2H7v2zm0-4h14v-2H7v2zm0-6v2h14V7H7z"/></svg>
      <span><a href="" style="text-decoration:none; color:white;">Reports</a></span>
    </div> -->
  </nav>

  <main>
    <div class="top-bar" role="banner">
      <div class="page-title">Dashboard</div>
      <div class="right-controls">
        <div class="notification" role="button" aria-label="View notifications" tabindex="0">
          <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
            <path d="M12 22c1.1 0 1.99-.9 1.99-2H10c0 1.1.9 2 2 2zM18 16v-5c0-3.07-1.63-5.64-4.5-6.32V4a1.5 1.5 0 0 0-3 0v.68C7.63 5.36 6 7.92 6 11v5l-1.99 2h14L18 16z"/>
          </svg>
          <span class="badge" aria-live="polite" aria-atomic="true">3</span>
        </div>
        <div class="user-profile" role="button" aria-label="User profile" tabindex="0">
          <div class="user-avatar" aria-hidden="true">A</div>
          <div class="user-name"><?php echo $_SESSION['user'];?></div>
         <a href="logout.php" class="logout-btn" role="button" aria-label="Logout">
            <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
              <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/>
            </svg>
            Logout
          </a>
        </div>
      </div>
    </div>
<div class="alert">
<?php if (isset($_SESSION['msg'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['msg']; unset($_SESSION['msg']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
</div>
    <div class="cards ">
      <section class="card booking-view-card " aria-label="Bookings Section">
        <h2>Current Bookings</h2>
        <button class="btn" onclick="openModal()">+ New Booking</button>

        <!-- Demo Booking Table -->
        <table class="booking-table" aria-label="Booking Details Table">
          <thead>
            <tr>
              <th>Booking ID</th>
              <th>Guest Name</th>
              <th>Room</th>
              <th>Date</th>
              <th>Status</th>
              <th>Delete</th>
              <th>Update</th>
            </tr>
          </thead>
          <tbody>
           <?php while($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?= $row['bookingID']; ?></td>
                <td><?= $row['guestName']; ?></td>
                <td><?= $row['roomNumber']; ?></td>
                <td><?= $row['date']; ?></td>
                <td><?= $row['status']; ?></td>
                 <td>
                    <a href="bookdelete.php?id=<?= $row['bookingID']; ?>" 
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Are you sure you want to delete this student?');">
                       Delete
                    </a>
                </td>
                <td>
                    <a href="bookupdate.php?id=  <?= $row['bookingID']; ?>   " class="btn btn-primary btn-sm">Update</a>
                </td>
            </tr>
        <?php } ?>
          </tbody>
        </table>
      </section>
    </div>
  </main>
</div>

<!-- Booking Modal -->
<div class="modal" id="bookingModal" role="dialog" aria-modal="true" aria-labelledby="bookingFormLabel">
  <div class="modal-content">
    <button class="close-btn" onclick="closeModal()" aria-label="Close modal">&times;</button>
    <h3 id="bookingFormLabel">New Booking</h3>
    <form id="bookingForm" action="savebooking.php" method="POST">
      
      <label for="guestName">Guest Name</label>
      <input type="text" id="guestName" name="guestName" required>

      <label for="roomNumber">Room</label>
      <select id="roomNumber" name="roomNumber" required>
        <option value="">Select Room</option>
        <option value="101">Room 101</option>
        <option value="204">Room 204</option>
        <option value="305">Room 305</option>
      </select>

      <label for="date">Booking Date</label>
      <input type="date" id="date" name="date" required>

      <label for="status">Status</label>
      <select id="status" name="status" required>
        <option value="Confirmed">Confirmed</option>
        <option value="Pending">Pending</option>
        <option value="Cancelled">Cancelled</option>
      </select>

      <button type="submit" class="submit-btn">Submit</button>
    </form>
  </div>
</div>

<script>
  function openModal() {
    document.getElementById('bookingModal').style.display = 'flex';
  }

  function closeModal() {
    document.getElementById('bookingModal').style.display = 'none';
  }

  // Example submission handler
//   document.getElementById('bookingForm').addEventListener('submit', function(event) {
//     event.preventDefault();
//     alert('Booking Submitted!');
//     closeModal();
//     // Add real submission logic here (AJAX or form POST)
//   });
</script>
</body>
</html>
</content>
</create_file>

