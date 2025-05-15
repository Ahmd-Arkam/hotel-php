<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Dashboard - Login</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .dashboard-card {
            max-width: 500px;
            margin: 50px auto;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border: none;
        }
        .card-header {
            background-color: #2c3e50;
            color: white;
            border-radius: 10px 10px 0 0 !important;
            padding: 15px 20px;
        }
        .btn-hotel {
            background-color: #3498db;
            color: white;
        }
        .btn-hotel:hover {
            background-color: #2980b9;
            color: white;
        }
        .form-label {
            font-weight: 500;
            color: #2c3e50;
        }
        .alert-message {
            border-radius: 5px;
        }
        .form-control {
            padding: 10px 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card dashboard-card">
            <div class="card-header">
                <h4 class="mb-0">USER LOGIN</h4>
            </div>
            <div class="card-body p-4">
                <?php if(isset($_SESSION['msg'])): ?>
                    <div class="alert alert-<?= strpos($_SESSION['msg'], 'success') !== false ? 'success' : 'danger' ?> alert-message mb-4">
                        <?= $_SESSION['msg'] ?>
                    </div>
                    <?php unset($_SESSION['msg']); ?>
                <?php endif; ?>

                <form action="check.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-hotel btn-lg">Login</button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center py-3">
                Don't have an account? <a href="user-registration.php" class="text-decoration-none">Register here</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>