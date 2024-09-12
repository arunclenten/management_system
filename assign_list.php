<?php
include("header.php");
include 'db.php'; // Include your database connection

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['return'])) {
        // Return asset
        $assignment_id = $_POST['assignment_id'];

        $sql = "UPDATE asset_assignments SET status = 'Returned' WHERE id = :assignment_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':assignment_id' => $assignment_id]);

        echo "<script>
                Swal.fire('Success', 'Asset returned successfully!', 'success').then(function() {
                    window.location.href = 'assignment_list.php';
                });
              </script>";
    }
}

// Fetch all assignments
$query = "SELECT aa.id AS assignment_id, e.unique_id AS employee_id, e.name, a.unique_id AS asset_id, 
                 a.category, aa.assignment_date, aa.status
          FROM asset_assignments aa
          JOIN employees e ON aa.employee_id = e.id
          JOIN assets a ON aa.asset_id = a.id";
$stmt = $pdo->prepare($query);
$stmt->execute();
$assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!-- Asset Assignment List -->
<div class="text-end">
    <a href="assignment_insert.php" class="btn btn-danger text-white">Assign Asset to Employee</a>
</div>
<div class="container mt-5">
    <h2>Asset Assignment List</h2>
    <table id="example" class="table table-striped table-bordered nowrap" style="width:100%">
        <thead>
            <tr>
                <th>Assignment ID</th>
                <th>Employee ID</th>
                <th>Employee Name</th>
                <th>Asset ID</th>
                <th>Asset Category</th>
                <th>Assignment Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($assignments as $assignment) : ?>
                <tr>
                    <td><?php echo $assignment['assignment_id']; ?></td>
                    <td><?php echo $assignment['employee_id']; ?></td>
                    <td><?php echo $assignment['name']; ?></td>
                    <td><?php echo $assignment['asset_id']; ?></td>
                    <td><?php echo $assignment['category']; ?></td>
                    <td><?php echo $assignment['assignment_date']; ?></td>
                    <td><?php echo $assignment['status']; ?></td>
                    <td>
                        <form method="POST" action="assignment_insert.php" style="display:inline;">
                            <input type="hidden" name="assignment_id" value="<?php echo $assignment['assignment_id']; ?>">
                            <button type="submit" class="btn btn-success text-white" name="return">Return</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
include('footer.php');
?>
