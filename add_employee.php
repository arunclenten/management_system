<?php
include("header.php");
include 'db.php'; // Include your database connection

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $name = $_POST['name'];
    $department = $_POST['department'];
    $position = $_POST['position'];
    $email = $_POST['email'];

    // Generate a unique ID in the format emp1234
    do {
        $random_number = random_int(1000, 9999); // Generate a random number between 1000 and 9999
        $unique_id = 'EMP' . $random_number;

        // Check if this unique_id already exists in the database
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM employees WHERE unique_id = :unique_id");
        $stmt->execute([':unique_id' => $unique_id]);
        $exists = $stmt->fetchColumn();
    } while ($exists > 0); // Keep generating until a unique ID is found

    // Prepare and execute the insert query using PDO
    $query = "INSERT INTO employees (unique_id, name, department, position, email) 
              VALUES (:unique_id, :name, :department, :position, :email)";
    $stmt = $pdo->prepare($query);

    // Bind parameters and execute the statement
    try {
        $stmt->execute([
            ':unique_id' => $unique_id,
            ':name' => $name,
            ':department' => $department,
            ':position' => $position,
            ':email' => $email
        ]);

        echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Registration Successful!',
                    showConfirmButton: true,
                    timer: 2000
                }).then(function() {
                    // Clear the form fields after successful submission
                    document.querySelector('form').reset();
                    window.location.href = 'employee.php';
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

<form action="add_employee.php" method="post" class="auth-form auth-signup-form text-center">
    <h1 class="text-center text-white">Add New Employee</h1><br>
    <!-- <label for="name" class="text-white">Name:</label><br> -->
    <input type="text" id="name" name="name" class="form-control" placeholder="Name" required><br>
    <br>

    <!-- <label for="department" class="text-white">Department:</label><br> -->
    <input type="text" id="department" class="form-control" placeholder="Department" name="department"><br>
    <br>

    <!-- <label for="position" class="text-white">Position:</label><br> -->
    <input type="text" id="position" class="form-control" placeholder="Position" name="position"><br>
    <br>

    <!-- <label for="email" class="text-white">Email:</label><br> -->
    <input type="email" id="email" class="form-control" name="email" placeholder="Email" required><br>
 
    <div class="text-center"><br>
        <button type="submit" class="btn bg-white text-success">Add Employee</button>
    </div>
   
</form>
</div>
<?php 
include("footer.php");
?>