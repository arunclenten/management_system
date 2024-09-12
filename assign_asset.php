<?php
// assign_asset.php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employee_name = $_POST['employee_name'];
    $asset_type = $_POST['asset_type'];
    $assignment_date = $_POST['assignment_date'];
    $notes = $_POST['notes'];

    $stmt = $pdo->prepare("INSERT INTO asset_assignments (employee_name, asset_type, assignment_date, status, notes) VALUES (?, ?, ?, 'Assigned', ?)");
    if ($stmt->execute([$employee_name, $asset_type, $assignment_date, $notes])) {
        echo '<script>Swal.fire("Assigned!", "Asset assigned successfully.", "success");</script>';
    } else {
        echo '<script>Swal.fire("Error!", "There was a problem assigning the asset.", "error");</script>';
    }
}
?>
