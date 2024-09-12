<?php
include("header.php");
include 'db.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: asset.php');
    exit;
}

$asset = $pdo->query("SELECT * FROM assets WHERE id = $id")->fetch(PDO::FETCH_ASSOC);

if (!$asset) {
    echo "<script>
        Swal.fire('Error', 'Asset not found.', 'error').then(() => {
            window.location = 'asset.php';
        });
    </script>";
    exit;
}
?>

<div class="container mt-5">
    <h2>Asset Details</h2>
    <table class="table table-bordered">
        <tr>
            <th>Category</th>
            <td><?= htmlspecialchars($asset['category']) ?></td>
        </tr>
        <tr>
            <th>Sub Category</th>
            <td><?= htmlspecialchars($asset['sub_category']) ?></td>
        </tr>
        <tr>
            <th>Type</th>
            <td><?= htmlspecialchars($asset['type']) ?></td>
        </tr>
        <tr>
            <th>Brand</th>
            <td><?= htmlspecialchars($asset['brand']) ?></td>
        </tr>
        <tr>
            <th>Price</th>
            <td><?= htmlspecialchars($asset['price']) ?></td>
        </tr>
        <tr>
            <th>Expiry Date</th>
            <td><?= htmlspecialchars($asset['expiry_date']) ?></td>
        </tr>
        <tr>
            <th>Working Condition</th>
            <td><?= htmlspecialchars($asset['working_condition']) ?></td>
        </tr>
    </table>
    <a href="asset.php" class="btn btn-secondary">Back to Asset List</a>
</div>

<?php include('footer.php'); ?>
