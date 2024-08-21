<?php
session_start();
require 'projectConnect.php';

if (!isset($_SESSION['super_id'])) {
    header('Location: supersignin.php');
    exit();
}

$supervisor_id = $_SESSION['super_id'];

$query = "SELECT student_id,  firstName, lastName, email FROM `students_table` WHERE supervisor_id = ?";
$prepare = $connection->prepare($query);
$prepare->bind_param("i", $supervisor_id);
$prepare->execute();
$result = $prepare->get_result();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['edit'])) {
        $student_id = $_POST['student_id'];

        var_dump($student_id);
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        if ($student_id) { 
            $updateQuery = "UPDATE `students_table` SET firstName=?, lastName=?, email=? WHERE student_id=?";
            $updateStmt = $connection->prepare($updateQuery);
            $updateStmt->bind_param("sssi", $firstName, $lastName, $email, $student_id);
            $updateStmt->execute();
            header('Location: superdash.php');
            exit();
        } else {
            echo "Student ID is missing.";
        }
    } elseif (isset($_POST['delete'])) {
        $student_id = $_POST['student_id'];
        var_dump($student_id);

        $deleteQuery = "DELETE FROM `students_table` WHERE student_id=?";
        $deleteStmt = $connection->prepare($deleteQuery);
        $deleteStmt->bind_param("i", $student_id);
        $deleteStmt->execute();
        header('Location: superdash.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supervisor Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center my-5 mb-5">Welcome, Supervisor</h1>
    
    <h3 class="my-3">Assigned Students:</h3>

    <table class="table shadow table-bordered">
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                $students = $result->fetch_all(MYSQLI_ASSOC);
            
                foreach ($students as $row) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['firstName']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['lastName']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>";
                    echo "<button type='button' class='btn mx-3 btn-outline-primary' data-bs-toggle='modal' data-bs-target='#editModal' data-id='{$row['student_id']}' data-firstname='{$row['firstName']}' data-lastname='{$row['lastName']}' data-email='{$row['email']}'>Edit</button>";
                    echo "<button type='button' class='btn btn-outline-danger' data-bs-toggle='modal' data-bs-target='#deleteModal' data-id='{$row['student_id']}'>Delete</button>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4' class='text-center'>No students assigned</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>




<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="student_id" id="edit-student_id">
                    <div class="mb-3">
                        <label for="firstName" class="form-label">First Name</label>
                        <input type="text" class="form-control" name="firstName" id="edit-firstName" required>
                    </div>
                    <div class="mb-3">
                        <label for="lastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" name="lastName" id="edit-lastName" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="edit-email" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="edit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>





<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this student?</p>
                    <input type="hidden" name="student_id" id="delete-student-id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="delete" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    var editModal = document.getElementById('editModal');
    editModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-id');
        var firstName = button.getAttribute('data-firstname');
        var lastName = button.getAttribute('data-lastname');
        var email = button.getAttribute('data-email');

        var modalBodyInputId = editModal.querySelector('#edit-student_id');
        var modalBodyInputFirstName = editModal.querySelector('#edit-firstName');
        var modalBodyInputLastName = editModal.querySelector('#edit-lastName');
        var modalBodyInputEmail = editModal.querySelector('#edit-email');

        modalBodyInputId.value = id;
        modalBodyInputFirstName.value = firstName;
        modalBodyInputLastName.value = lastName;
        modalBodyInputEmail.value = email;
    });

    var deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-id');

        var modalBodyInputId = deleteModal.querySelector('#delete-student-id');
        modalBodyInputId.value = id;
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
