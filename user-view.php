<?php
include("header.php");
require_once 'db.php';

// Check if an ID is provided in the URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch user data from the database based on the ID
    $sql = "SELECT * FROM user_table WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the user exists
    if (!$user) {
        echo "<div class='alert alert-danger'>User not found.</div>";
    } else {
        // Display user details
        ?>
        <div class="container mt-5">
            <h2>User Details</h2>
            <div class="row">
                <div class="col-md-6">
                    <strong>Name:</strong> <?php echo $user['name']; ?><br>
                    <strong>Phone:</strong> <?php echo $user['phone']; ?><br>
                    <strong>Email:</strong> <?php echo $user['email']; ?><br>
                    <strong>User Type:</strong> <?php echo $user['user_type']; ?><br>
                </div>
                <div class="col-md-6 text-center">
                    <img src="uploads/<?php echo $user['profile_picture']; ?>" class="img-fluid rounded-circle" width="150" alt="User Profile Picture">
                </div>
            </div>
            <div class="mt-3">
                <a href="user.php" class="btn btn-primary">Back to User List</a>
            </div>
        </div>
        <?php
    }
} else {
    echo "<div class='alert alert-danger'>Invalid request.</div>";
}

include("footer.php");
?>
