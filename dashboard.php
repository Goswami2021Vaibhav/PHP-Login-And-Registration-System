<?php
session_start();
require 'checklogin.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center" style="height:100vh">
        <div class="text-center">
            <h1 class="mb-5">Welcome To Dashboard</h1>
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    User Id
                    <span class="badge bg-secondary badge-pill"><?php echo $_SESSION['user_id'] ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    User Name
                    <span class="badge bg-secondary badge-pill"><?php echo $_SESSION['user_name'] ?></span>
                </li>

            </ul>

            <div class="text-center mt-5">
                <a href="logout.php" class="btn btn-primary">Logout</a>
            </div>

        </div>
    </div>
</body>

</html>