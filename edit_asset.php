<?php
include("header.php");
include 'db.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: read.php');
    exit;
}

$asset = $pdo->query("SELECT * FROM assets WHERE id = $id")->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['update'])) {
    $category = $_POST['category'];
    $sub_category = $_POST['sub_category'];
    $type = $_POST['type'];
    $brand = $_POST['brand'];
    $price = $_POST['price'];
    $expiry_date = $_POST['expiry_date'];
    $working_condition = $_POST['working_condition'];

    $sql = "UPDATE assets SET 
                category = :category, 
                sub_category = :sub_category, 
                type = :type, 
                brand = :brand, 
                price = :price, 
                expiry_date = :expiry_date, 
                working_condition = :working_condition 
            WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([
        ':id' => $id,
        ':category' => $category,
        ':sub_category' => $sub_category,
        ':type' => $type,
        ':brand' => $brand,
        ':price' => $price,
        ':expiry_date' => $expiry_date,
        ':working_condition' => $working_condition,
    ])) {
        echo "<script>
            Swal.fire('Success', 'Asset updated successfully!', 'success').then(() => {
                window.location = 'asset.php';
            });
        </script>";
    } else {
        echo "<script>
            Swal.fire('Error', 'Failed to update asset.', 'error');
        </script>";
    }
}
?>
<div class="auth-form-container text-start mx-auto">

<form action="edit_asset.php?id=<?= $asset['id'] ?>" method="POST" class="auth-form auth-signup-form">
<h2 class="text-center text-white">Edit Asset</h2>
    <label class="text-white">Category:</label><br>
    <select name="category" required class="form-control">
        <option value="Electronics" <?= $asset['category'] == 'Electronics' ? 'selected' : '' ?>>Electronics</option>
        <option value="Furniture" <?= $asset['category'] == 'Furniture' ? 'selected' : '' ?>>Furniture</option>
        <option value="Vehicles" <?= $asset['category'] == 'Vehicles' ? 'selected' : '' ?>>Vehicles</option>
    </select><br>
    
    <label class="text-white">Sub Category:</label><br>
    <select name="sub_category" required class="form-control">
        <option value="Laptop" <?= $asset['sub_category'] == 'Laptop' ? 'selected' : '' ?>>Laptop</option>
        <option value="Table" <?= $asset['sub_category'] == 'Table' ? 'selected' : '' ?>>Table</option>
        <option value="Car" <?= $asset['sub_category'] == 'Car' ? 'selected' : '' ?>>Car</option>
    </select><br>
    
    <label class="text-white">Type:</label><br>
    <input type="text" name="type" value="<?= $asset['type'] ?>" class="form-control" required><br>
    
    <label class="text-white">Brand:</label><br>
    <input type="text" name="brand" value="<?= $asset['brand'] ?>" class="form-control" required><br>
    
    <label class="text-white">Price:</label><br>
    <input type="number" step="0.01" name="price" value="<?= $asset['price'] ?>" class="form-control" required><br>
    
    <label class="text-white">Expiry Date:</label><br>
    <input type="date" name="expiry_date" value="<?= $asset['expiry_date'] ?>" class="form-control" required><br>
    
    <label class="text-white">Working Condition:</label><br>
    <input type="text" name="working_condition" value="<?= $asset['working_condition'] ?>" class="form-control" required><br><br>
    <div class="text-center">
    <button type="submit" class="btn bg-white text-success" name="update">Update Asset</button>
    </div>
  
</form>
</div>
<?php 
include("footer.php");
?>
