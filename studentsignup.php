<!-- 




<?php

// require 'projectConnect.php';

// session_start();

// if (isset($_POST['submit'])) {

//     // echo 'Processing...';

//     $fname = $_POST['firstName'];
//     $lname = $_POST['lastName'];
//     $email = $_POST['email'];
//     $password = $_POST['password'];
//     $supervisor_id = $_POST['supervisor_id']; 
    

//     $query = "SELECT * FROM `students_table` WHERE email = ?";
//     $prepare = $connection->prepare($query);
//     $prepare->bind_param('s', $email);
//     $success = $prepare->execute();

//     if ($success) {
//         $user = $prepare->get_result();
//         if ($user->num_rows > 0) {
//             echo "Email already exists";
//         } else {
//             $hashedpass = password_hash($password, PASSWORD_DEFAULT);

//             $query = "INSERT INTO `students_table` (`firstName`, `lastName`, `email`, `password`, `supervisor_id`) VALUES (?, ?, ?, ?, ?)";
//             $prepare = $connection->prepare($query);
//             $prepare->bind_param("ssssi", $fname, $lname, $email, $hashedpass, $supervisor_id);
//             // echo $prepare;
//             $execute = $prepare->execute();
//             if ($execute) {
//                 $_SESSION['msg'] = 'Successfully signed up';
//                 header('location:studentsignin.php');
//                 exit();
//             } else {
//                 echo 'Data not inserted: ' . $connection->error;
//             }
//         }
//     } else {
//         echo 'Query execution failed: ' . $connection->error;
//     }
// } else {
//     echo "No form submission detected.";
// }



?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register as a Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<div class="container w-50 border border-radius-4 mt-5 p-4 shadow shadow-5">
    <form action="studentsignup.php" method="POST">
        <h1 class="text-center mb-5 text-primary">Register as a Student</h1>


        <?php
        // if (isset($_SESSION['mesg'])) {
        //     echo "<div class='text-danger text-center mb-3'>" . $_SESSION['mesg'] . "</div>";
        //     unset($_SESSION['mesg']);
        // }

        // if (isset($_SESSION['msg'])) {
        //     echo "<div class='text-success text-center mb-3'>" . $_SESSION['msg'] . "</div>";
        //     unset($_SESSION['msg']);
        //     echo "<script>
        //         setTimeout(function() {
        //             window.location.href = 'studentsignin.php';
        //         }, 3000);
        //     </script>";
        // }
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



        <div class="mb-3">
    <label for="supervisor" class="form-label">Select Supervisor</label>
    <select class="form-control" id="supervisor" name="supervisor_id" required>
        <?php
        // require 'projectConnect.php';

        // $Query = "SELECT supervisor_id, firstName, lastName FROM `supervisors_table`";
        // $result = $connection->query($Query);

        // if ($result->num_rows > 0) {
        //     while ($row = $result->fetch_assoc()) {
        //         echo "<option value='" . $row['supervisor_id'] . "'>" . $row['firstName'] . "  ". $row['lastName']. "</option>";
        //     }
        // } else {
        //     echo "<option value=''>No supervisors available</option>";
        // }
        ?>
    </select>
</div>

        
        <button type="submit" class="btn btn-primary" name="submit">Sign up</button>
    </form>

    <div>
        <p>Already have an accout with us ?
  <a href="studentsignin.php" class="">Sign in here</a>

        </p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html> -->












<?php

require 'projectConnect.php';

session_start();

if (isset($_POST['submit'])) {

    $fname = $_POST['firstName'];
    $lname = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $supervisor_id = 3;
    

    $query = "SELECT * FROM `students_table` WHERE email = ?";
    $prepare = $connection->prepare($query);
    $prepare->bind_param('s', $email);
    $success = $prepare->execute();

    if ($success) {
        $user = $prepare->get_result();
        if ($user->num_rows > 0) {
            echo "Email already exists";
        } else {
            $hashedpass = password_hash($password, PASSWORD_DEFAULT);

            $query = "INSERT INTO `students_table` (`firstName`, `lastName`, `email`, `password`, `supervisor_id`) VALUES (?, ?, ?, ?, ?)";
            $prepare = $connection->prepare($query);
            $prepare->bind_param("ssssi", $fname, $lname, $email, $hashedpass, $supervisor_id);
            $execute = $prepare->execute();
            if ($execute) {
                $_SESSION['msg'] = 'Successfully signed up';
                header('location:studentsignin.php');
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
    <title>Register as a Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<div class="container w-50 border border-radius-4 mt-5 p-4 shadow shadow-5">
    <form action="studentsignup.php" method="POST">
        <h1 class="text-center mb-5 text-primary">Register as a Student</h1>

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
                    window.location.href = 'studentsignin.php';
                }, 3000);
            </script>";
        }
        ?>

        <div class="container-fluid gap-5 d-flex">
            <div class="mb-3">
                <label for="firstName" class="w-50 form-label">First Name</label>
                <input type="text" class="form-control" id="firstName" name="firstName" required>
            </div>
            <div class="mb-3">
                <label for="lastName" class="w-50 form-label">Last Name</label>
                <input type="text" class="form-control" id="lastName" name="lastName" required>
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
        <p>Already have an account with us?
            <a href="studentsignin.php" class="">Sign in here</a>
        </p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
