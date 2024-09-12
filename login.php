<?php
session_start();
include 'db.php'; // Include your database connection

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    // Redirect based on user type
    if ($_SESSION['user_type'] == 'super-admin') {
        header('Location: dashboard.php');
    } else {
        header('Location: user.php');
    }
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = md5($_POST['password']); // Assuming passwords are hashed with MD5

    $stmt = $pdo->prepare("SELECT * FROM user_table WHERE email = :email AND password = :password LIMIT 1");
    $stmt->execute(['email' => $email, 'password' => $password]);
    $user = $stmt->fetch();

    if ($user) {
        // Store user information in session variables
        $_SESSION['user_id'] = $user['unique_id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_phone'] = $user['phone'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_type'] = $user['user_type'];
        $_SESSION['user_image'] = $user['profile_picture'];

        // Set a session variable to trigger SweetAlert
        $_SESSION['login_success'] = true;

        // Redirect based on user type
        if ($user['user_type'] == 'super-admin') {
            header('Location: dashboard.php');
        } else {
            header('Location: user.php');
        }
        exit();
    } else {
        // Login failed
        $error_message = 'Invalid email or password.';
    }
}
?>

<!DOCTYPE html>
<html lang="en"> 
<head>
    <title>Office Inventory Management System</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Office Inventory Management System">
    <meta name="author" content="Xiaoying Riley at 3rd Wave Media">    
    <!-- <link rel="shortcut icon" href="favicon.ico">  -->
    <script defer src="assets/plugins/fontawesome/js/all.min.js"></script>
    <link id="theme-style" rel="stylesheet" href="assets/css/portal.css">
    <!-- SweetAlert CSS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head> 

<body class="app app-login p-0"> 

<?php if (isset($error_message)): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Login Failed',
                text: '<?php echo $error_message; ?>',
                confirmButtonText: 'Try Again'
            });
        </script>
    <?php endif; ?>   	
    <div class="row g-0 app-auth-wrapper">
	    <div class="col-12 col-md-7 col-lg-6 auth-main-col text-center p-5">
		    <div class="d-flex flex-column align-content-end">
			    <div class="app-auth-body mx-auto">	
				    <div class="app-auth-branding mb-4"><a class="app-logo" href="index.html"><img class="logo-icon me-2" src="assets/images/app-logo.svg" alt="logo"></a></div>
					<h2 class="auth-heading text-center mb-5">Log in to Admin Penal</h2>
			        <div class="auth-form-container text-start">
						<form class="auth-form login-form" action="login.php" method="POST">         
							<div class="email mb-3">
								<label class="sr-only" for="signin-email">Email</label>
								<input id="signin-email" id="email" name="email" type="email" class="form-control signin-email" placeholder="Email address" required="required">
							</div>
							<div class="password mb-3">
								<label class="sr-only" for="signin-password">Password</label>
								<input id="signin-password" id="password" name="password" type="password" class="form-control signin-password" placeholder="Password" required="required">
							</div>
							<div class="text-center">
								<button type="submit" class="btn app-btn-primary w-100 theme-btn mx-auto">Log In</button>
							</div>
						</form>
					</div>
			    </div>
			    <footer class="app-auth-footer">
				    <div class="container text-center py-3">
			        <small class="copyright">Designed with <span class="sr-only">love</span><i class="fas fa-heart" style="color: #fb866a;"></i> by <a class="app-link" href="http://themes.3rdwavemedia.com" target="_blank">Arun clenten</a> for developers</small>
				    </div>
			    </footer>	
		    </div>   
	    </div>
	    <div class="col-12 col-md-5 col-lg-6 h-100 auth-background-col">
		    <div class="auth-background-holder"></div>
		    <div class="auth-background-mask"></div>
		</div>
    </div>

  
</body>
</html>