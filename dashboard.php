<?php

session_start();
if(!isset($_SESSION['user']))
{
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Hotel Management Dashboard - Black & White Theme</title>
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
  .card.chart-card {
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

    <div class="nav-item active" title="Dashboard" aria-current="page" tabindex="0">
      <!-- Home icon -->
      <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg>
      <span><a href="dashboard.php" style="text-decoration:none; color:white;">Dashboard</a></span>
    </div>
    <div class="nav-item" title="Bookings" tabindex="0">
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

    <div class="cards" role="region" aria-label="Hotel data cards">

      <section class="card" aria-label="Occupancy Rate">
        <h2>Occupancy Rate</h2>
        <div class="value" aria-live="polite">78%</div>
        <div class="subtitle">Current month</div>
      </section>
      <section class="card" aria-label="Occupancy Rate">
        <h2>Occupancy Rate</h2>
        <div class="value" aria-live="polite">78%</div>
        <div class="subtitle">Current month</div>
      </section>

      <section class="card" aria-label="Room Status">
        <h2>Room Status</h2>
        <div class="room-status" role="list">
          <div class="room-status-item" role="listitem"><span>Occupied</span><span>39</span></div>
          <div class="room-status-item" role="listitem"><span>Vacant</span><span>11</span></div>
          <div class="room-status-item" role="listitem"><span>Under Maintenance</span><span>2</span></div>
        </div>
      </section>

      <section class="card chart-card" aria-label="Bookings Chart">
        <h2>Bookings</h2>
        <canvas id="bookingsChart" role="img" aria-label="Bookings chart showing bookings per week"></canvas>
      </section>

      <section class="card chart-card" aria-label="Revenue Chart">
        <h2>Revenue</h2>
        <canvas id="revenueChart" role="img" aria-label="Revenue chart showing monthly revenue"></canvas>
      </section>

    </div>
  </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Bookings Chart Data & Config
  const bookingsCtx = document.getElementById('bookingsChart').getContext('2d');
  const bookingsChart = new Chart(bookingsCtx, {
    type: 'bar',
    data: {
      labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
      datasets: [{
        label: 'Bookings',
        data: [45, 60, 40, 55],
        backgroundColor: 'var(--color-dark-gray)',
        borderColor: 'var(--color-black)',
        borderWidth: 1,
        hoverBackgroundColor: 'var(--color-mid-gray)',
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        x: {
          ticks: { color: 'var(--color-black)', font: { weight: '700' } },
          grid: { display: false },
          border: { display: false }
        },
        y: {
          beginAtZero: true,
          ticks: { color: 'var(--color-black)' },
          grid: { color: 'var(--color-light-gray)' },
          border: { display: false }
        }
      },
      plugins: {
        legend: { display: false },
        tooltip: { enabled: true }
      }
    }
  });

  // Revenue Chart Data & Config
  const revenueCtx = document.getElementById('revenueChart').getContext('2d');
  const revenueChart = new Chart(revenueCtx, {
    type: 'line',
    data: {
      labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
      datasets: [{
        label: 'Revenue',
        data: [12000, 15000, 13000, 14000, 17000],
        fill: false,
        borderColor: 'var(--color-black)',
        backgroundColor: 'var(--color-dark-gray)',
        tension: 0.25,
        pointRadius: 5,
        pointHoverRadius: 7,
        borderWidth: 2,
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        x: {
          ticks: { color: 'var(--color-black)', font: { weight: '700' } },
          grid: { display: false },
          border: { display: false }
        },
        y: {
          beginAtZero: false,
          ticks: { color: 'var(--color-black)' },
          grid: { color: 'var(--color-light-gray)' },
          border: { display: false }
        }
      },
      plugins: {
        legend: { display: false },
        tooltip: { enabled: true }
      }
    }
  });
</script>
</body>
</html>
</content>
</create_file>

