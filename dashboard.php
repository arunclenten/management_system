<?php
include("header.php");

// Access the values
$totalUsers = $_SESSION['totalUsers'];
$totalAsset = $_SESSION['totalAsset'];
$totalEmployees = $_SESSION['totalEmployees'];
$totalAssignment = $_SESSION['totalAssignment'];
$returnedCount = isset($_SESSION['returnedCount']) ? $_SESSION['returnedCount'] : 0;
$assignedCount = isset($_SESSION['assignedCount']) ? $_SESSION['assignedCount'] : 0;
$Electronics = isset($_SESSION['Electronics']) ? $_SESSION['Electronics'] : 0;
$Vehicles = isset($_SESSION['Vehicles']) ? $_SESSION['Vehicles'] : 0;
$Furniture = isset($_SESSION['Furniture']) ? $_SESSION['Furniture'] : 0;

if (isset($_SESSION['login_success'])) {
    echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        Swal.fire({
            title: 'Login Successful!',
            text: 'Welcome back, {$_SESSION['user_name']}!',
            icon: 'success',
            confirmButtonText: 'OK'
      
        });
    </script>";
}
?>



<div class="container-xl">

	<h1 class="app-page-title">Overview</h1>



	<div class="row g-4 mb-4">
		<div class="col-6 col-lg-3">
			<div class="app-card app-card-stat shadow-sm h-100">
				<div class="app-card-body p-3 p-lg-3">
					<h4 class="stats-type mb-1">Total User</h4>
					<div class="stats-figure"><?php echo $totalUsers; ?></div>
				
				</div><!--//app-card-body-->
				<a class="app-card-link-mask" href="#"></a>
			</div><!--//app-card-->
		</div><!--//col-->

		<div class="col-6 col-lg-3">
			<div class="app-card app-card-stat shadow-sm h-100">
				<div class="app-card-body p-3 p-lg-3">
					<h4 class="stats-type mb-1">Total Employees</h4>
					<div class="stats-figure"><?php echo $totalEmployees; ?></div>
				
				</div>
				<a class="app-card-link-mask" href="#"></a>
			</div>
		</div>
		<div class="col-6 col-lg-3">
			<div class="app-card app-card-stat shadow-sm h-100">
				<div class="app-card-body p-3 p-lg-3">
					<h4 class="stats-type mb-1">Total Assets</h4>
					<div class="stats-figure"><?php echo $totalAsset; ?></div>
				
				</div>
				<a class="app-card-link-mask" href="#"></a>
			</div>
		</div>
		<div class="col-6 col-lg-3">
			<div class="app-card app-card-stat shadow-sm h-100">
				<div class="app-card-body p-3 p-lg-3">
					<h4 class="stats-type mb-1">Assignment</h4>
					<div class="stats-figure"><?php echo $totalAssignment; ?></div>
					<!-- <div class="stats-figure"><?php echo $Electronics; ?></div> -->
					<!-- <div class="stats-figure"><?php echo $returnedCount ; ?></div> --> 
				</div>
				<a class="app-card-link-mask" href="#"></a>
			</div>
		</div>
	
	</div>
	<div class="row g-4 mb-4">
		<div class="col-12 col-lg-6">
			<div class="app-card app-card-chart h-100 shadow-sm">
				<div class="app-card-header p-3">
					<div class="row justify-content-between align-items-center">
						<div class="col-auto">
							<h4 class="app-card-title">Pie Chart</h4>
						</div><!--//col-->
						<div class="col-auto">
							
						</div><!--//col-->
					</div><!--//row-->
				</div><!--//app-card-header-->
				<div class="app-card-body p-3 p-lg-4">
				
					<div class="chart-container">
					<canvas id="pieChart" ></canvas>
					</div>
				</div><!--//app-card-body-->
			</div><!--//app-card-->
		</div><!--//col-->
		<div class="col-12 col-lg-6">
			<div class="app-card app-card-chart h-100 shadow-sm">
				<div class="app-card-header p-3">
					<div class="row justify-content-between align-items-center">
						<div class="col-auto">
							<h4 class="app-card-title">Bar Chart</h4>
						</div><!--//col-->
						
					</div><!--//row-->
				</div><!--//app-card-header-->
				<div class="app-card-body p-3 p-lg-4">
					
					<div class="chart-container">
					<canvas id="barChart"></canvas>
					</div>
				</div><!--//app-card-body-->
			</div><!--//app-card-->
		</div><!--//col-->

	</div><!--//row-->

	<section>
        <div class="row g-4 mb-4 chart-box">
            <div class="col-12 col-lg-6  chart-box-1">
                <div class="app-card app-card-chart h-100 shadow-sm">
                    <div class="app-card-header p-3 border-0">
                        <h4 class="app-card-title">Doughnut Chart </h4>
                    </div>
                    <div class="app-card-body p-4">
                        <div class="chart-container">
						<canvas id="doughnutChart" width="100" height="100"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </section>

</div><!--//container-fluid-->
</div><!--//app-content-->

<script>
        // Pie Chart
        var ctxPie = document.getElementById('pieChart').getContext('2d');
        var pieChart = new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: ['User', 'Assets','Employee'], // Example labels
                datasets: [{
                    label: 'value',
                    data: [<?php echo $totalUsers; ?>,<?php echo $totalAsset; ?>,<?php echo $totalEmployees; ?>], // Example data
                    backgroundColor: ['#75c181', '#5b99ea','#FF6384']
                }]
            },
            options: {
                responsive: true
            }
        });

        // Bar Chart
        var ctxBar = document.getElementById('barChart').getContext('2d');
        var barChart = new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: ['Electronics', 'Vehicles','Furniture'], // Example labels
                datasets: [{
                    label: 'Assests Category',
                    data: [<?php echo $Electronics; ?>,<?php echo $Vehicles; ?>,<?php echo $Furniture; ?>], // Example data
                    backgroundColor: '#FF6384'
                }]
            },
            options: {
                responsive: true
            }
        });

        // Doughnut Chart
        var ctxDoughnut = document.getElementById('doughnutChart').getContext('2d');
        var doughnutChart = new Chart(ctxDoughnut, {
            type: 'doughnut',
            data: {
                labels: ['Returned', 'Assigned'], // Example labels
                datasets: [{
                    label: 'Assignments Status',
                    data: [<?php echo $returnedCount ; ?>,<?php echo $assignedCount ; ?>], // Example data
                    backgroundColor: ['#FF6384', '#36A2EB']
                }]
            },
            options: {
                responsive: true
            }
        });
    </script>

</div><!--//app-wrapper-->

<?php
include("footer.php");
?>