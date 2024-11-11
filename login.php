<?php
include 'config.php';
$alert = false;
$message = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login_form'])) {

    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = mysqli_real_escape_string($conn, trim($_POST['password']));


    if (empty($email) || empty($password)) {
        $alert = true;
        $message = '<div class="alert alert-danger" role="alert">
                       All fields are required.
                    </div>';

    } else {
        $checkEmail = "select * from users where email = '$email'";
        $checkEmailQuery = mysqli_query($conn, $checkEmail);
        $checkEmailRow = mysqli_num_rows($checkEmailQuery);
        if ($checkEmailRow > 0) {
            $user = mysqli_fetch_assoc($checkEmailQuery);
            $userPassword = $user['password'];
            if (password_verify($password, $userPassword)) {
                session_start();
                $_SESSION['login_id'] = session_id();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['full_name'];
                header("location:dashboard.php");
            } else {
                $alert = true;
                $message = '<div class="alert alert-danger" role="alert">
                           Invalid login credentials.
                        </div>';
            }
        } else {
            $alert = true;
            $message = '<div class="alert alert-danger" role="alert">
                           Invalid login credentials.
                        </div>';
        }
    }



}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center" style="height:100vh">
        <div class="card">
            <div class="card-body" style="width:400px">
                <h3 class="mb-3">Login </h3>
                <form method="post" action="login.php">

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" placeholder="Enter your email" required name="email">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" placeholder="**********" name="password" required>
                    </div>

                    <div class="mb-3 text-center">
                        <button type="submit" class="btn btn-primary w-100 mb-3" name="login_form">Submit</button>
                        <p>
                            <a href="registration.php">Registration</a>
                        </p>
                    </div>
                    <div>
                        <?php
                        if ($alert) {
                            echo $message;
                        }
                        ?>
                    </div>

                </form>
            </div>
        </div>
    </div>
</body>

</html>