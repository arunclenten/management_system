<?php
include("header.php");

// Include the database connection file
require_once 'db.php';

// Function to validate input data
function validateInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Function to generate a unique user ID
function generateUniqueId($prefix = 'USER', $length = 4) {
    $random_number = mt_rand(10**($length-1), (10**$length)-1);
    return $prefix . $random_number;
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate inputs
    $name = validateInput($_POST['signup-name']);
    $phone = validateInput($_POST['signup-phone']);
    $email = validateInput($_POST['signup-email']);
    $user_type = validateInput($_POST['signup-user-type']);
    $password = validateInput($_POST['signup-password']);
    $confirm_password = validateInput($_POST['confirm-password']);
    $profile_picture = $_FILES['signup-profile']['name'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Passwords do not match!',
                    showConfirmButton: true,
                    timer: 2000
                }).then(function() {
                    
                    window.location.href = 'add_user.php';
                });
              </script>";
        exit();
    }

    // Hash the password using password_hash()
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Check if the email already exists in the database
    $sql = "SELECT COUNT(*) FROM user_table WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':email' => $email]);
    $email_exists = $stmt->fetchColumn();

    if ($email_exists) {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Email already exists!',
                    showConfirmButton: true,
                    timer: 2000
                }).then(function() {
                    
                    window.location.href = 'add_user.php';
                });
              </script>";
        exit();
    }

    // Generate a unique user ID
    $unique_id = generateUniqueId();

    // Check if the unique ID already exists in the database
    $sql = "SELECT COUNT(*) FROM user_table WHERE unique_id = :unique_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':unique_id' => $unique_id]);
    $id_exists = $stmt->fetchColumn();

    // Regenerate unique ID if it already exists
    while ($id_exists) {
        $unique_id = generateUniqueId();
        $stmt->execute([':unique_id' => $unique_id]);
        $id_exists = $stmt->fetchColumn();
    }

    // File upload handling
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($profile_picture);

    // Validate file type (example: allow only JPEG, PNG files)
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowed_types = ['jpg', 'jpeg', 'png'];
    if (!in_array($imageFileType, $allowed_types)) {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid file type!',
                    showConfirmButton: true,
                    timer: 2000
                }).then(function() {
                    
                    window.location.href = 'add_user.php';
                });
              </script>";
        exit();
    }

    // Validate file size (example: max 2MB)
    if ($_FILES['signup-profile']['size'] > 2 * 1024 * 1024) {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'File size exceeds 2MB!',
                    showConfirmButton: true,
                    timer: 2000
                }).then(function() {
                    
                    window.location.href = 'add_user.php';
                });
              </script>";
        exit();
    }

    if (!move_uploaded_file($_FILES['signup-profile']['tmp_name'], $target_file)) {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Failed to upload profile picture!',
                    showConfirmButton: true,
                    timer: 2000
                }).then(function() {
                    
                    window.location.href = 'add_user.php';
                });
              </script>";
        exit();
    }

    // Insert data into the database
    $sql = "INSERT INTO user_table (unique_id, name, phone, email, user_type, profile_picture, password) 
            VALUES (:unique_id, :name, :phone, :email, :user_type, :profile_picture, :password)";
    
    $stmt = $pdo->prepare($sql);
    
    // Execute the statement with the provided data
    if ($stmt->execute([
        ':unique_id' => $unique_id, 
        ':name' => $name, 
        ':phone' => $phone, 
        ':email' => $email, 
        ':user_type' => $user_type, 
        ':profile_picture' => $profile_picture, 
        ':password' => $hashed_password
    ])) {
        echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Registration Successful!',
                    showConfirmButton: true,
                    timer: 2000
                }).then(function() {
                    // Clear the form fields after successful submission
                    document.querySelector('.auth-signup-form').reset();
                    window.location.href = 'user.php';
                });
              </script>";
    } else {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Registration Failed!',
                    showConfirmButton: true,
                    timer: 2000
                });
              </script>";
    }
}
?>


<div class="auth-form-container text-start mx-auto">
    <form class="auth-form auth-signup-form" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
        <h2 class="text-center my-3 text-white">User Form</h2>
        <div class="mb-3">
            <label class="sr-only" for="signup-name">Your Name</label>
            <input id="signup-name" name="signup-name" type="text" class="form-control signup-name" placeholder="Full name" required="required">
            <div id="name-error" class="text-danger"></div>
        </div>

        <div class="mb-3">
            <label class="sr-only" for="signup-phone">Your Phone</label>
            <input id="signup-phone" name="signup-phone" type="text" class="form-control signup-phone" placeholder="Phone number" required="required">
            <div id="phone-error" class="text-danger"></div>
        </div>

        <div class="mb-3">
            <label class="sr-only" for="signup-email">Your Email</label>
            <input id="signup-email" name="signup-email" type="email" class="form-control signup-email" placeholder="Email" required="required">
        </div>

        <div class="mb-3">
            <label class="sr-only" for="signup-user-type">User Type</label>
            <select id="signup-user-type" name="signup-user-type" class="form-control signup-user-type" required="required">
                <option value="" disabled selected>Select User Type</option>
                <option value="admin">Admin</option>
                <option value="super-admin">Super Admin</option>
            </select>
            <div id="user-type-error" class="text-danger"></div>
        </div>

        <div class="mb-3">
            <label class="sr-only" for="signup-profile">Profile Picture</label>
            <input id="signup-profile" name="signup-profile" type="file" class="form-control signup-profile" accept="image/*" required="required">
        </div>

        <div class="mb-3">
            <label class="sr-only" for="signup-password">Password</label>
            <input id="signup-password" name="signup-password" type="password" class="form-control signup-password" placeholder="Create a password" required="required">
            <div id="password-error" class="text-danger"></div>
        </div>
        <div class="mb-3">
            <label class="sr-only" for="confirm-password">Confirm Password</label>
            <input id="confirm-password" name="confirm-password" type="password" class="form-control" placeholder="Confirm password" required="required">
            <div id="confirm-password-error" class="text-danger"></div>
        </div>
        <div class="text-center">
            <button type="submit" class="btn bg-white  mx-auto text-success">Create User</button>
        </div>
    </form><!--//auth-form-->
</div>

<script>
function validateForm() {
    let valid = true;

    // Validate name
    const name = document.getElementById('signup-name').value;
    const nameRegex = /^[a-zA-Z\s]+$/;
    if (!nameRegex.test(name)) {
        document.getElementById('name-error').innerText = 'Name can only contain letters.';
        valid = false;
    } else {
        document.getElementById('name-error').innerText = '';
    }

    // Validate phone
    const phone = document.getElementById('signup-phone').value;
    const phoneRegex = /^\d{10}$/;
    if (!phoneRegex.test(phone)) {
        document.getElementById('phone-error').innerText = 'Phone number must be exactly 10 digits.';
        valid = false;
    } else {
        document.getElementById('phone-error').innerText = '';
    }

    // Validate password
    const password = document.getElementById('signup-password').value;
    const passwordRegex = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/; // Minimum 8 characters, at least one letter and one number
    if (!passwordRegex.test(password)) {
        document.getElementById('password-error').innerText = 'Password must be at least 8 characters long and contain at least one letter and one number.';
        valid = false;
    } else {
        document.getElementById('password-error').innerText = '';
    }

    // Validate confirm password
    const confirmPassword = document.getElementById('confirm-password').value;
    if (confirmPassword !== password) {
        document.getElementById('confirm-password-error').innerText = 'Passwords do not match.';
        valid = false;
    } else {
        document.getElementById('confirm-password-error').innerText = '';
    }

    return valid;
}
</script>

<?php
include("footer.php");
?>
