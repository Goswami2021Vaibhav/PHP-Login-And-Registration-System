<?php
include 'config.php';
$alert = false;
$message = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login_form'])) {
    $full_name = mysqli_real_escape_string($conn, trim($_POST['full_name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = mysqli_real_escape_string($conn, trim($_POST['password']));
    $confirm_password = mysqli_real_escape_string($conn, trim($_POST['confirm_password']));

    if (empty($full_name) || empty($email) || empty($password) || empty($confirm_password)) {
        $alert = true;
        $message = '<div class="alert alert-danger" role="alert">
                       All fields are required.
                    </div>';

    } else if ($password != $confirm_password) {
        $alert = true;
        $message = '<div class="alert alert-danger" role="alert">
                       Password and confirm password should be same.
                    </div>';
    } else {
        $checkEmail = "select email from users where email = '$email'";
        $checkEmailQuery = mysqli_query($conn, $checkEmail);
        $checkEmailRow = mysqli_num_rows($checkEmailQuery);
        if ($checkEmailRow > 0) {
            $alert = true;
            $message = '<div class="alert alert-danger" role="alert">
                           User already registered.
                        </div>';
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $newRegistration = "INSERT INTO `users`(`full_name`, `email`, `password`) 
            VALUES ('$full_name','$email','$password_hash')";
            $registration_status = mysqli_query($conn, $newRegistration);
            if ($registration_status) {
                $alert = true;
                $message = '<div class="alert alert-success" role="alert">
                         User registeration success.
                        </div>';
            } else {
                $alert = true;
                $message = '<div class="alert alert-danger" role="alert">
                          Registeration failed.
                        </div>';
            }
        }
    }



}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center" style="height:100vh">
        <div class="card">
            <div class="card-body" style="width:400px">
                <h3 class="mb-3">Registration </h3>
                <form method="post" action="registration.php">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control" placeholder="Full name" name="full_name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" placeholder="Enter your email" required name="email">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" placeholder="**********" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" placeholder="**********" name="confirm_password"
                            required>
                    </div>
                    <div class="mb-3 text-center">
                        <button type="submit" class="btn btn-primary w-100 mb-3" name="login_form">Submit</button>
                        <p>
                            <a href="login.php" >Login</a>
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