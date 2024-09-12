<?php
include("header.php");
require_once 'db.php';

// Retrieve employee ID from URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the employee data from the database
    $sql = "SELECT * FROM employees WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    $employee = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if employee exists
    if (!$employee) {
        echo "<p>Employee not found.</p>";
        exit();
    }
} else {
    echo "<p>No employee ID specified.</p>";
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $name = $_POST['name'];
    $department = $_POST['department'];
    $position = $_POST['position'];
    $email = $_POST['email'];

    // Prepare and execute the update query
    $query = "UPDATE employees SET name = :name, department = :department, position = :position, email = :email WHERE id = :id";
    $stmt = $pdo->prepare($query);

    // Bind parameters and execute the statement
    try {
        $stmt->execute([
            ':name' => $name,
            ':department' => $department,
            ':position' => $position,
            ':email' => $email,
            ':id' => $id
        ]);

        echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Update Successful!',
                    showConfirmButton: true,
                    timer: 2000
                }).then(function() {
                    window.location.href = 'employee.php'; // Redirect to employee list page
                });
              </script>";
    } catch (PDOException $e) {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: '" . addslashes($e->getMessage()) . "',
                    showConfirmButton: true,
                    timer: 2000
                });
              </script>";
    }
}
?>


<div class="auth-form-container text-start mx-auto">

    <form action="edit_employee.php?id=<?php echo $id; ?>" method="post" class="auth-form auth-signup-form">
    <h1 class="text-center text-white">Edit Employee</h1>
        <label for="name" class="text-white">Name:</label>
        <input type="text" id="name" name="name" class="form-control" value="<?php echo htmlspecialchars($employee['name']); ?>"  required>
        <br>

        <label for="department" class="text-white">Department:</label>
        <input type="text" id="department" name="department" class="form-control" value="<?php echo htmlspecialchars($employee['department']); ?>">
        <br>

        <label for="position" class="text-white">Position:</label>
        <input type="text" id="position" name="position" class="form-control" value="<?php echo htmlspecialchars($employee['position']); ?>">
        <br>

        <label for="email" class="text-white">Email:</label>
        <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($employee['email']); ?>" required>
        <br>
<div class="text-center">
<button type="submit" class="btn bg-white text-success">Update Employee</button>

</div>
    </form>
</div>


<?php  
include("footer.php");
?>
