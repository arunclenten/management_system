<?php
include("header.php");
include 'db.php';

if (isset($_POST['create'])) {
    $category = $_POST['category'];
    $sub_category = $_POST['sub_category'];
    $type = $_POST['type'];
    $brand = $_POST['brand'];
    $price = $_POST['price'];
    $expiry_date = $_POST['expiry_date'];
    $working_condition = $_POST['working_condition'];

    // Generate a unique ID in the format ass4563
    // Generate a random number between 1000 and 9999 (you can adjust the range as needed)
    do {
        $random_number = random_int(1000, 9999);
        $unique_id = 'ASS' . $random_number;

        // Check if this unique_id already exists in the database
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM assets WHERE unique_id = :unique_id");
        $stmt->execute([':unique_id' => $unique_id]);
        $exists = $stmt->fetchColumn();
    } while ($exists > 0); // Keep generating until a unique ID is found

    $sql = "INSERT INTO assets (unique_id, category, sub_category, type, brand, price, expiry_date, working_condition) 
            VALUES (:unique_id, :category, :sub_category, :type, :brand, :price, :expiry_date, :working_condition)";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([
        ':unique_id' => $unique_id,
        ':category' => $category,
        ':sub_category' => $sub_category,
        ':type' => $type,
        ':brand' => $brand,
        ':price' => $price,
        ':expiry_date' => $expiry_date,
        ':working_condition' => $working_condition,
    ])) {
        echo "<script>
            Swal.fire('Success', 'Asset added successfully!', 'success').then(() => {
                window.location = 'asset.php';
            });
        </script>";
    } else {
        echo "<script>
            Swal.fire('Error', 'Failed to add asset.', 'error');
        </script>";
    }
}
?>

<div class="auth-form-container text-start mx-auto">

<form action="create-asset.php" class="auth-form auth-signup-form" method="POST">
<h2 class="text-center text-white">Add New Asset</h2>
    <label class="text-white">Category:</label><br>
    <select name="category" class="form-control" id="category" required>
        <option value="">Select Category</option>
        <option value="Electronics">Electronics</option>
        <option value="Furniture">Furniture</option>
        <option value="Vehicles">Vehicles</option>
    </select><br>
    
    <label class="text-white">Sub Category:</label><br>
    <select name="sub_category" class="form-control" id="sub_category" required>
        <option value="">Select Sub Category</option>
    </select><br>
    
    <label class="text-white">Type:</label><br>
    <input type="text" class="form-control" name="type" required><br>
    
    <label class="text-white">Brand:</label><br>
    <input type="text" class="form-control" name="brand" required><br>
    
    <label class="text-white">Price:</label><br>
    <input type="number" class="form-control" step="0.01" name="price" required><br>
    
    <label class="text-white">Expiry Date:</label><br>
    <input type="date" class="form-control" name="expiry_date" required><br>
    
    <label class="text-white">Working Condition:</label><br>
    <select name="working_condition" class="form-control" required>
        <option value="Good">Good</option>
        <option value="Bad">Bad</option>
        <option value="Fair">Fair</option>
    </select><br><br>
    <div class="text-center">
    <button type="submit" class="btn bg-white text-success" name="create">Add Asset</button>

    </div>
</form>
</div>
<script>
    const subCategoryOptions = {
        Electronics: [
            { value: "Laptop", text: "Laptop" },
            { value: "Tab", text: "Tab" },
            { value: "Mobile", text: "Mobile" }
        ],
        Furniture: [
            { value: "Chair", text: "Chair" },
            { value: "Table", text: "Table" },
            { value: "Sofa", text: "Sofa" }
        ],
        Vehicles: [
            { value: "Car", text: "Car" },
            { value: "Bike", text: "Bike" },
            { value: "Truck", text: "Truck" }
        ]
    };

    document.getElementById('category').addEventListener('change', function() {
        const selectedCategory = this.value;
        const subCategorySelect = document.getElementById('sub_category');

        // Clear the current sub-category options
        subCategorySelect.innerHTML = '<option value="">Select Sub Category</option>';

        // Populate sub-category options based on selected category
        if (subCategoryOptions[selectedCategory]) {
            subCategoryOptions[selectedCategory].forEach(option => {
                const newOption = document.createElement('option');
                newOption.value = option.value;
                newOption.textContent = option.text;
                subCategorySelect.appendChild(newOption);
            });
        }
    });
</script>

<?php
include('footer.php');
?>
