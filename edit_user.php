<?php
include("header.php");
require_once 'db.php';

// Get the user ID from the URL
$id = $_GET['id'];

// Fetch the user data from the database
$sql = "SELECT * FROM user_table WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id' => $id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $user_type = $_POST['user_type'];
    $profile_picture = $user['profile_picture']; // Default to existing picture

    // Check if a new profile picture was uploaded
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["profile_picture"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Allow certain file formats
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        if (in_array($imageFileType, $allowed_types)) {
            // Save the uploaded file
            if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
                $profile_picture = basename($_FILES["profile_picture"]["name"]);
            } else {
                echo "<script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed to upload image!',
                            showConfirmButton: true,
                            timer: 2000
                        });
                      </script>";
            }
        } else {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Only JPG, JPEG, PNG & GIF files are allowed.',
                        showConfirmButton: true,
                        timer: 2000
                    });
                  </script>";
        }
    }

    // Update the user data in the database
    $sql = "UPDATE user_table SET name = :name, phone = :phone, email = :email, user_type = :user_type, profile_picture = :profile_picture WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([':name' => $name, ':phone' => $phone, ':email' => $email, ':user_type' => $user_type, ':profile_picture' => $profile_picture, ':id' => $id])) {
        echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'User updated successfully!',
                    showConfirmButton: true,
                    timer: 2000
                }).then(function() {
                    window.location.href = 'user.php';
                });
              </script>";
    } else {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Failed to update user!',
                    showConfirmButton: true,
                    timer: 2000
                });
              </script>";
    }
}
?>

<div class="container mt-5">
<div class="auth-form-container text-start mx-auto">
  
    <form method="POST" class="auth-form auth-signup-form" enctype="multipart/form-data">
    <h2 class="text-center text-white">Edit User</h2>
        <div class="mb-3">
            <label for="name" class="form-label text-white" >Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo $user['name']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label text-white" >Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $user['phone']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label text-white" >Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="user_type" class="form-label text-white" >User Type</label>
            <select class="form-control" id="user_type" name="user_type" required>
                <option value="admin" <?php echo ($user['user_type'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                <option value="super-admin" <?php echo ($user['user_type'] == 'super-admin') ? 'selected' : ''; ?>>Super Admin</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="profile_picture" class="form-label text-white" >Profile Picture</label>
            <input type="file" class="form-control" id="profile_picture" name="profile_picture">
            <!-- Display current profile picture -->
            <img src="uploads/<?php echo $user['profile_picture']; ?>" width="100" class="mt-3">
        </div>
        <div class="text-center">
        <button type="submit" class="btn bg-white text-success">Update User</button>

        </div>
    </form>
</div>

<?php
include("footer.php");
?>
