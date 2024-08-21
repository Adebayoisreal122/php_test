
<?php



require 'projectConnect.php';

session_start();

if (isset($_POST['submit'])) {

    // echo 'Processing...';

    $fname = $_POST['firstName'];
    $lname = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM `supervisors_table` WHERE email = ?";
    $prepare = $connection->prepare($query);
    $prepare->bind_param('s', $email);
    $success = $prepare->execute();

    if ($success) {
        $user = $prepare->get_result();
        if ($user->num_rows > 0) {
            echo "Email already exists";
        } else {
            $hashedpass = password_hash($password, PASSWORD_DEFAULT);

            $query = "INSERT INTO `supervisors_table` (`firstName`, `lastName`, `email`, `password`) VALUES (?, ?, ?, ?)";
            $prepare = $connection->prepare($query);
            $prepare->bind_param("ssss", $fname, $lname, $email, $hashedpass);
            // echo $prepare;
            $execute = $prepare->execute();
            if ($execute) {
                $_SESSION['msg'] = 'Successfully signed up';
                header('location:supersignin.php');
                exit();
            } else {
                echo 'Data not inserted: ' . $connection->error;
            }
        }
    } else {
        echo 'Query execution failed: ' . $connection->error;
    }
} else {
    echo "No form submission detected.";
}




?>














<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register as a Supervisor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<div class="container w-50 border border-radius-4 mt-5 p-4 shadow shadow-5">
    <form action="supersignup.php" method="POST">
        <h1 class="text-center mb-5 text-primary">Register as a Supervisor</h1>


        <?php
        if (isset($_SESSION['mesg'])) {
            echo "<div class='text-danger text-center mb-3'>" . $_SESSION['mesg'] . "</div>";
            unset($_SESSION['mesg']);
        }

        if (isset($_SESSION['msg'])) {
            echo "<div class='text-success text-center mb-3'>" . $_SESSION['msg'] . "</div>";
            unset($_SESSION['msg']);
            echo "<script>
                setTimeout(function() {
                    window.location.href = 'eliteSellerSignin.php';
                }, 3000);
            </script>";
        }
        ?>

        <div class="container-fluid gap-5 d-flex">
            <div class="mb-3">
                <label for="firstName" class="w-50 form-label">First Name</label>
                <input type="text" class="form-control" id="firstName" name="firstName">
            </div>
            <div class="mb-3">
                <label for="lastName" class="w-50 form-label">Last Name</label>
                <input type="text" class="form-control" id="lastName" name="lastName" >
            </div>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
    
        <button type="submit" class="btn btn-primary" name="submit">Sign up</button>
    </form>

    <div>
        <p>Already have an accout with us ?
  <a href="supersignin.php" class="">Sign in here</a>

        </p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
