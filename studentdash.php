<?php
session_start();
require 'projectConnect.php';

// Check if the student is logged in
if (!isset($_SESSION['stud_id'])) {
    header('Location: studentsignin.php');
    exit();
}

// Get the logged-in student's ID
$student_id = $_SESSION['stud_id'];

// Query to retrieve only the student's details
$query = "SELECT * FROM `students_table` WHERE student_id = ?";
$prepare = $connection->prepare($query);
$prepare->bind_param("i", $student_id);
$prepare->execute();
$result = $prepare->get_result();

$student = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-5">Student Dashboard</h1>
    
    <h3>Student Details:</h3>
    <table class="table shadow table-bordered">
        <tr>
            <th>First Name</th>
            <td><?php echo htmlspecialchars($student['firstName']); ?></td>
        </tr>
        <tr>
            <th>Last Name</th>
            <td><?php echo htmlspecialchars($student['lastName']); ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?php echo htmlspecialchars($student['email']); ?></td>
        </tr>

        <tr>
            <th>Supervisor ID</th>
            <td><?php echo htmlspecialchars($student['supervisor_id']); ?></td>
        </tr>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
