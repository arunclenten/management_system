<?php
include("header.php");
include 'db.php'; // Include your database connection

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['assign'])) {
        // Assign asset to employee
        $employee_id = $_POST['employee_id'];
        $asset_id = $_POST['asset_id'];
        $assignment_date = $_POST['assignment_date'];
        $notes = $_POST['notes'];

        $sql = "INSERT INTO asset_assignments (employee_id, asset_id, assignment_date, notes, status)
                VALUES (:employee_id, :asset_id, :assignment_date, :notes, 'Assigned')";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':employee_id' => $employee_id,
            ':asset_id' => $asset_id,
            ':assignment_date' => $assignment_date,
            ':notes' => $notes,
        ]);

        echo "<script>Swal.fire('Success', 'Asset assigned successfully!', 'success').then(function() {
                    
                    window.location.href = 'assign_list.php';
                });</script>";
    } elseif (isset($_POST['update'])) {
        // Update asset assignment
        $assignment_id = $_POST['assignment_id'];
        $employee_id = $_POST['employee_id'];
        $asset_id = $_POST['asset_id'];
        $assignment_date = $_POST['assignment_date'];
        $notes = $_POST['notes'];

        $sql = "UPDATE asset_assignments SET employee_id = :employee_id, asset_id = :asset_id, 
                assignment_date = :assignment_date, notes = :notes WHERE id = :assignment_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':employee_id' => $employee_id,
            ':asset_id' => $asset_id,
            ':assignment_date' => $assignment_date,
            ':notes' => $notes,
            ':assignment_id' => $assignment_id,
        ]);

        echo "<script>Swal.fire('Success', 'Assignment updated successfully!', 'success').then(function() {
                    
                    window.location.href = 'assign_list.php';
                });</script>";
    } elseif (isset($_POST['return'])) {
        // Return asset
        $assignment_id = $_POST['assignment_id'];

        $sql = "UPDATE asset_assignments SET status = 'Returned' WHERE id = :assignment_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':assignment_id' => $assignment_id]);

        echo "<script>Swal.fire('Success', 'Asset returned successfully!', 'success').then(function() {
                    
                    window.location.href = 'assign_list.php';
                });</script>";
    }
}

// Fetch all employees and assets for assignment
$employees = $pdo->query("SELECT id, unique_id, name FROM employees")->fetchAll(PDO::FETCH_ASSOC);
$assets = $pdo->query("SELECT id, unique_id, category FROM assets WHERE id NOT IN (SELECT asset_id FROM asset_assignments WHERE status = 'Assigned')")->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Asset Assignment Form -->
<div class="auth-form-container text-start mx-auto">

<form method="POST" class="auth-form auth-signup-form" action="assignment_insert.php">
<h2 class="text-white text-center">Assign Asset to Employee</h2>
    <label for="employee_id" class="text-white">Employee:</label>
    <select name="employee_id" required class="form-control">
        <option value="">Select Employee</option>
        <?php foreach ($employees as $employee) : ?>
            <option value="<?php echo $employee['id']; ?>"><?php echo $employee['unique_id'] . ' - ' . $employee['name']; ?></option>
        <?php endforeach; ?>
    </select><br>

    <label for="asset_id" class="text-white">Asset:</label>
    <select name="asset_id" required class="form-control">
        <option value="">Select Asset</option>
        <?php foreach ($assets as $asset) : ?>
            <option value="<?php echo $asset['id']; ?>"><?php echo $asset['unique_id'] . ' - ' . $asset['category']; ?></option>
        <?php endforeach; ?>
    </select><br>

    <label for="assignment_date" class="text-white">Assignment Date:</label>
    <input type="date" name="assignment_date" class="form-control" required><br>

    <label for="notes" class="text-white">Notes:</label>
    <textarea name="notes" class="form-control"></textarea><br>
<div class="text-center">
<button type="submit" class="btn bg-white text-success" name="assign">Assign Asset</button>
</div>
</form>
</div>
<?php
include('footer.php');
?>
