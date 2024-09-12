<?php
session_start();

// Redirect to login page if not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Retrieve user details from session
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'Unknown';
$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Guest';
$user_phone = isset($_SESSION['user_phone']) ? $_SESSION['user_phone'] : 'Unknown';
$user_email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : 'Unknown';
$user_type = isset($_SESSION['user_type']) ? $_SESSION['user_type'] : 'Unknown';
$user_image = isset($_SESSION['user_image']) ? $_SESSION['user_image'] : 'default-image.png'; // Use a default image if none is set
?>


<!DOCTYPE html>
<html lang="en">

<head>
	<title>Office Inventory Management System</title>

	<!-- Meta -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<meta name="description" content="Office Inventory Management System">
	<meta name="author" content="Xiaoying Riley at 3rd Wave Media">
	<!-- <link rel="shortcut icon" href="favicon.ico">  -->

	<!-- FontAwesome JS-->
	<script defer src="assets/plugins/fontawesome/js/all.min.js"></script>

	<!-- App CSS -->
	<link id="theme-style" rel="stylesheet" href="assets/css/portal.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/2.1.5/css/dataTables.dataTables.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/3.1.2/css/buttons.dataTables.css">
	<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<!-- sweet alert scrpit file -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.0/dist/sweetalert2.min.js"></script>

</head>
<style>
	.auth-form {
		width: 50%;
		background: #51b37f;
		padding: 15px 60px;
		border-radius: 15px;
	}

	.auth-form-container {
		display: flex;
		justify-content: center;
	}

	.chart-container {
		width: 300px;
    height: 300px;
    display: flex;
    align-content: center;
    justify-content: flex-end;
    flex-wrap: wrap;
	}

	/* .app-card {
		width: 400px;
	} */
</style>

<body class="app">
	<header class="app-header fixed-top">
		<div class="app-header-inner">
			<div class="container-fluid py-2">
				<div class="app-header-content">
					<div class="row justify-content-between align-items-center">

						<div class="col-auto">
							<a id="sidepanel-toggler" class="sidepanel-toggler d-inline-block d-xl-none" href="#">
								<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" role="img">
									<title>Menu</title>
									<path stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="2" d="M4 7h22M4 15h22M4 23h22"></path>
								</svg>
							</a>
						</div><!--//col-->



						<div class="app-utilities col-auto">
							<div class="app-utility-item app-notifications-dropdown dropdown">
								<!--//dropdown-toggle-->

								<div class="dropdown-menu p-0" aria-labelledby="notifications-dropdown-toggle">
									<div class="dropdown-menu-header p-3">
										<h5 class="dropdown-menu-title mb-0">Notifications</h5>
									</div><!--//dropdown-menu-title-->
									<div class="dropdown-menu-content">
										<div class="item p-3">
											<div class="row gx-2 justify-content-between align-items-center">
												<div class="col-auto">
													<img class="profile-image" src="assets/images/profiles/profile-1.png" alt="">
												</div><!--//col-->
												<div class="col">
													<div class="info">
														<div class="desc">Amy shared a file with you. Lorem ipsum dolor sit amet, consectetur adipiscing elit. </div>
														<div class="meta"> 2 hrs ago</div>
													</div>
												</div><!--//col-->
											</div><!--//row-->
											<a class="link-mask" href="notifications.html"></a>
										</div><!--//item-->
										<div class="item p-3">
											<div class="row gx-2 justify-content-between align-items-center">
												<div class="col-auto">
													<div class="app-icon-holder">
														<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-receipt" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
															<path fill-rule="evenodd" d="M1.92.506a.5.5 0 0 1 .434.14L3 1.293l.646-.647a.5.5 0 0 1 .708 0L5 1.293l.646-.647a.5.5 0 0 1 .708 0L7 1.293l.646-.647a.5.5 0 0 1 .708 0L9 1.293l.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .801.13l.5 1A.5.5 0 0 1 15 2v12a.5.5 0 0 1-.053.224l-.5 1a.5.5 0 0 1-.8.13L13 14.707l-.646.647a.5.5 0 0 1-.708 0L11 14.707l-.646.647a.5.5 0 0 1-.708 0L9 14.707l-.646.647a.5.5 0 0 1-.708 0L7 14.707l-.646.647a.5.5 0 0 1-.708 0L5 14.707l-.646.647a.5.5 0 0 1-.708 0L3 14.707l-.646.647a.5.5 0 0 1-.801-.13l-.5-1A.5.5 0 0 1 1 14V2a.5.5 0 0 1 .053-.224l.5-1a.5.5 0 0 1 .367-.27zm.217 1.338L2 2.118v11.764l.137.274.51-.51a.5.5 0 0 1 .707 0l.646.647.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.509.509.137-.274V2.118l-.137-.274-.51.51a.5.5 0 0 1-.707 0L12 1.707l-.646.647a.5.5 0 0 1-.708 0L10 1.707l-.646.647a.5.5 0 0 1-.708 0L8 1.707l-.646.647a.5.5 0 0 1-.708 0L6 1.707l-.646.647a.5.5 0 0 1-.708 0L4 1.707l-.646.647a.5.5 0 0 1-.708 0l-.509-.51z" />
															<path fill-rule="evenodd" d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm8-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5z" />
														</svg>
													</div>
												</div><!--//col-->
												<div class="col">
													<div class="info">
														<div class="desc">You have a new invoice. Proin venenatis interdum est.</div>
														<div class="meta"> 1 day ago</div>
													</div>
												</div><!--//col-->
											</div><!--//row-->
											<a class="link-mask" href="notifications.html"></a>
										</div><!--//item-->
										<div class="item p-3">
											<div class="row gx-2 justify-content-between align-items-center">
												<div class="col-auto">
													<div class="app-icon-holder icon-holder-mono">
														<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-bar-chart-line" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
															<path fill-rule="evenodd" d="M11 2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h1V7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7h1V2zm1 12h2V2h-2v12zm-3 0V7H7v7h2zm-5 0v-3H2v3h2z" />
														</svg>
													</div>
												</div><!--//col-->
												<div class="col">
													<div class="info">
														<div class="desc">Your report is ready. Proin venenatis interdum est.</div>
														<div class="meta"> 3 days ago</div>
													</div>
												</div><!--//col-->
											</div><!--//row-->
											<a class="link-mask" href="notifications.html"></a>
										</div><!--//item-->
										<div class="item p-3">
											<div class="row gx-2 justify-content-between align-items-center">
												<div class="col-auto">
													<img class="profile-image" src="assets/images/profiles/profile-2.png" alt="">
												</div><!--//col-->
												<div class="col">
													<div class="info">
														<div class="desc">James sent you a new message.</div>
														<div class="meta"> 7 days ago</div>
													</div>
												</div><!--//col-->
											</div><!--//row-->
											<!-- <a class="link-mask" href="notifications.html"></a> -->
										</div><!--//item-->
									</div><!--//dropdown-menu-content-->

									<!-- <div class="dropdown-menu-footer p-2 text-center">
							        <a href="notifications.html">View all</a>
						        </div> -->

								</div><!--//dropdown-menu-->
							</div><!--//app-utility-item-->
							<div class="app-utility-item">

							</div><!--//app-utility-item-->

							<div class="app-utility-item app-user-dropdown dropdown">
								<a class="dropdown-toggle" id="user-dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"><img src="./uploads/<?php echo htmlspecialchars($user_image); ?>" alt="user profile"></a>
								<ul class="dropdown-menu" aria-labelledby="user-dropdown-toggle">
									<li><a class="dropdown-item" href="#"><?php echo htmlspecialchars($user_name); ?></a></li>
								<li><a class="dropdown-item" href="#"><?php echo htmlspecialchars($user_type); ?></a></li>
								<li><hr class="dropdown-divider"></li>
									<li><a class="dropdown-item" href="logout.php">Log Out</a></li>
								</ul>
							</div><!--//app-user-dropdown-->
						</div><!--//app-utilities-->
					</div><!--//row-->
				</div><!--//app-header-content-->
			</div><!--//container-fluid-->
		</div><!--//app-header-inner-->
		<div id="app-sidepanel" class="app-sidepanel">
			<div id="sidepanel-drop" class="sidepanel-drop"></div>
			<div class="sidepanel-inner d-flex flex-column">
				<a href="#" id="sidepanel-close" class="sidepanel-close d-xl-none">&times;</a>
				<div class="app-branding">
					<a class="app-logo" href="dashboard.php"><img class="logo-icon me-2" src="assets/images/app-logo.svg" alt="logo"><span class="logo-text">Admin Penal</span></a>

				</div><!--//app-branding-->

				<nav id="app-nav-main" class="app-nav app-nav-main flex-grow-1">
					<ul class="app-menu list-unstyled accordion" id="menu-accordion">
						<li class="nav-item">
							<a class="nav-link active" href="dashboard.php">
								<span class="nav-icon">
									<i class="fa-solid fa-house"></i>
								</span>
								<span class="nav-link-text">Dashboard</span>
							</a><!--//nav-link-->
						</li>
						<li class="nav-item">
							<a class="nav-link <?php echo ($current_page == 'user.php') ? 'active' : ''; ?>" href="user.php">
								<span class="nav-icon">
									<i class="fa-solid fa-user"></i>
								</span>
								<span class="nav-link-text">User</span>
							</a><!--//nav-link-->
						</li>
						<li class="nav-item">
							<a class="nav-link <?php echo ($current_page == 'asset.php') ? 'active' : ''; ?>" href="asset.php">
								<span class="nav-icon">
									<i class="fa-solid fa-address-card"></i>
								</span>
								<span class="nav-link-text">Asset</span>
							</a><!--//nav-link-->
						</li>
						<li class="nav-item">
							<a class="nav-link <?php echo ($current_page == 'employee.php') ? 'active' : ''; ?>" href="employee.php">
								<span class="nav-icon">
									<i class="fa-solid fa-users"></i>
								</span>
								<span class="nav-link-text">Employee</span>
							</a><!--//nav-link-->
						</li>
						<li class="nav-item">
							<a class="nav-link <?php echo ($current_page == 'assign_list.php') ? 'active' : ''; ?>" href="assign_list.php">
								<span class="nav-icon">
									<i class="fa-solid fa-person-harassing"></i>
								</span>
								<span class="nav-link-text">Assignment</span>
							</a><!--//nav-link-->
						</li>
					</ul><!--//app-menu-->
				</nav>


			</div><!--//sidepanel-inner-->
		</div><!--//app-sidepanel-->
	</header><!--//app-header-->
	<div class="app-wrapper">

		<div class="app-content pt-3 p-md-3 p-lg-4">




		<script>
        document.addEventListener('DOMContentLoaded', function() {
            const navLinks = document.querySelectorAll('.nav-link');

            navLinks.forEach(link => {
                link.addEventListener('click', function(event) {
                    event.preventDefault();  // Prevent default link behavior

                    // Remove 'active' class from all nav links
                    navLinks.forEach(link => link.classList.remove('active'));

                    // Add 'active' class to the clicked nav link
                    this.classList.add('active');

                    // Uncomment this line to enable navigation
                    // window.location.href = this.href;
                });
            });
        });
    </script>