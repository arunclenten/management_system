<?php
include("header.php");
include 'db.php';

// Fetch all assets
$assets = $pdo->query("SELECT * FROM assets")->fetchAll(PDO::FETCH_ASSOC);
$sno = 1;
?>

<div class="text-end">
    <a href="create-asset.php" class="btn btn-danger text-white">Create Asset</a>
</div>
<div class="container mt-5">
    <h2>Asset List</h2>
    <table id="example" class="table table-striped table-bordered nowrap" style="width:100%">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Unique id</th>
                <th>Category</th>
                <th>Sub Category</th>
                <th>Type</th>
                <th>Brand</th>
                <th>Price</th>
                <th>Expiry Date</th>
                <th>Working Condition</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($assets as $asset): ?>
            <tr>
                <td><?php echo $sno++; ?></td>
                <td><?= htmlspecialchars($asset['unique_id']) ?></td>
                <td><?= htmlspecialchars($asset['category']) ?></td>
                <td><?= htmlspecialchars($asset['sub_category']) ?></td>
                <td><?= htmlspecialchars($asset['type']) ?></td>
                <td><?= htmlspecialchars($asset['brand']) ?></td>
                <td><?= htmlspecialchars($asset['price']) ?></td>
                <td><?= htmlspecialchars($asset['expiry_date']) ?></td>
                <td><?= htmlspecialchars($asset['working_condition']) ?></td>
                <td>
                    <a href="asset_view.php?id=<?= $asset['id'] ?>" class="btn btn-info"><i class="fa-solid fa-eye text-white"></i></a>
                    <a href="edit_asset.php?id=<?= $asset['id'] ?>" class="btn btn-warning"><i class="fa-solid fa-pen-to-square text-white"></i></a>
                    <a href="javascript:void(0);" onclick="confirmDelete(<?= $asset['id']; ?>)" class="btn btn-danger"><i class="fa-solid fa-trash text-white"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
function confirmDelete(assetId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'delete_asset.php',
                type: 'POST',
                data: { id: assetId },
                success: function(response) {
                    Swal.fire(
                        'Deleted!',
                        'The asset has been deleted.',
                        'success'
                    ).then(function() {
                        window.location.href = 'asset.php';
                    });
                },
                error: function() {
                    Swal.fire(
                        'Failed!',
                        'There was an error deleting the asset.',
                        'error'
                    );
                }
            });
        }
    });
}
</script>

<?php include('footer.php'); ?>
