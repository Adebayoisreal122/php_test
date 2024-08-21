



<?php



require 'projectConnect.php';


session_start();

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT * FROM `supervisors_table` WHERE email = ?";
    $prepare = $connection->prepare($query);
    $prepare->bind_param('s', $email);
    $prepare->execute();
    $result = $prepare->get_result();

    if ($result) {
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $hashedpassword = $user['password'];
            $verified_password = password_verify($password, $hashedpassword);

            if ($verified_password) {
                $_SESSION['super_id'] = $user['supervisor_id'];
                header('location:superdash.php');
                exit();
            } else {
                echo "Invalid email or password";
            }
        } else {
            echo "Invalid email or password";
        }
    } else {
        echo "Error executing query: " . $connection->error;
    }
}
?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sign in</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<body>


<div class="container w-50 border border-radius-4 mt-5 p-4 shadow shadow-5">
        
        <form   action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            
            <h1 class="text-center mb-5 text-primary">Sign In</h1>
       
       
       
        
     
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email address</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
        </div>
        <div class="mb-3">
          <label for="exampleInputPassword1" class="form-label">Password</label>
          <input type="password" class="form-control" id="exampleInputPassword1" name="password">
        </div>
     
        <button type="submit" class="btn btn-primary" name="submit">Register</button>
    </form>

    <div>
        <p>You don't have an accout with us? 
  <a href="supersignup.php" class="">Sign up here</a>

        </p>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>

