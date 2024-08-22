<?php
session_start();
require 'projectConnect.php';


if (!isset($_SESSION['stud_id'])) {
    header('Location: studentsignin.php');
    exit();
}

$student_id = $_SESSION['stud_id'];



$query = "SELECT  students_table.student_id, students_table.firstName  AS student_firstName,  students_table.lastName AS student_lastname, students_table.email AS student_email, supervisors_table.firstName AS supervisor_firstName,  supervisors_table.supervisor_id AS super_id, supervisors_table.lastName AS supervisor_lastName FROM `students_table` JOIN `supervisors_table` ON students_table.supervisor_id= supervisors_table.supervisor_id WHERE student_id = ?";
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
            <td>
                <?php
                 echo htmlspecialchars($student['student_firstName']); 
                ?>
        </td>
        </tr>
        <tr>
            <th>Last Name</th>
            <td><?php echo htmlspecialchars($student['student_lastname']); ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?php echo htmlspecialchars($student['student_email']); ?></td>
        </tr>

        <tr>
            <th>Supervisor ID</th>
            <td><?php echo htmlspecialchars($student['super_id']); ?></td>
        </tr>

        <tr>
            <th>Supervisor Name</th>
            <td><?php echo htmlspecialchars($student['supervisor_firstName']) . ' ' . htmlspecialchars($student['supervisor_lastName']); ?></td>

        </tr>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
