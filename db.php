<?php
// Start the session
// session_start();

// Database connection
$dsn = "mysql:host=localhost;dbname=management_system";
$username = "root";
$password = "";

try {
  $pdo = new PDO($dsn, $username, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // Fetch total users
  $stmtUsers = $pdo->query("SELECT COUNT(*) as total_users FROM user_table");
  $resultUsers = $stmtUsers->fetch(PDO::FETCH_ASSOC);
  $totalUsers = $resultUsers['total_users'];

  // Fetch total Employees
  $stmtEmployees = $pdo->query("SELECT COUNT(*) as total_employees FROM employees");
  $resultEmployees = $stmtEmployees->fetch(PDO::FETCH_ASSOC);
  $totalEmployees = $resultEmployees['total_employees'];


  
  // Fetch total Asset
  $stmtAsset = $pdo->query("SELECT COUNT(*) as total_assets FROM assets");
  $resultAsset = $stmtAsset->fetch(PDO::FETCH_ASSOC);
  $totalAsset = $resultAsset['total_assets'];

   // Define the categoryes you want to track
 $subcategory = ['Electronics', 'Vehicles','Furniture'];
 $subcategoryCounts = [];

 // Fetch counts for each category
 foreach ($subcategory as $category) {
     $stmt = $pdo->prepare("SELECT COUNT(*) as count_category FROM assets WHERE category = :category");
     $stmt->execute([':category' => $category]);
     $result = $stmt->fetch(PDO::FETCH_ASSOC);
     $subcategoryCounts[$category] = $result['count_category'];
 }

 // Fetch total assignments
 $stmtAssignment = $pdo->query("SELECT COUNT(*) as total_assignments FROM asset_assignments");
 $resultAssignment = $stmtAssignment->fetch(PDO::FETCH_ASSOC);
 $totalAssignment = $resultAssignment['total_assignments'];

 // Define the statuses you want to track
 $substatuses = ['Returned', 'Assigned'];
 $substatusCounts = [];

 // Fetch counts for each status
 foreach ($substatuses as $status) {
     $stmt = $pdo->prepare("SELECT COUNT(*) as count_status FROM asset_assignments WHERE status = :status");
     $stmt->execute([':status' => $status]);
     $result = $stmt->fetch(PDO::FETCH_ASSOC);
     $substatusCounts[$status] = $result['count_status'];
 }


  // Store the values in session variables
  $_SESSION['totalUsers'] = $totalUsers;
  $_SESSION['totalAsset'] = $totalAsset;
  $_SESSION['totalEmployees'] = $totalEmployees;
  $_SESSION['totalAssignment'] = $totalAssignment;
  // Store the values in session variables
 $_SESSION['returnedCount'] = isset($substatusCounts['Returned']) ? $substatusCounts['Returned'] : 0;
 $_SESSION['assignedCount'] = isset($substatusCounts['Assigned']) ? $substatusCounts['Assigned'] : 0;

 $_SESSION['Electronics'] = isset($subcategoryCounts['Electronics']) ? $subcategoryCounts['Electronics'] : 0;
 $_SESSION['Vehicles'] = isset($subcategoryCounts['Vehicles']) ? $subcategoryCounts['Vehicles'] : 0; 
 $_SESSION['Furniture'] = isset($subcategoryCounts['Furniture']) ? $subcategoryCounts['Furniture'] : 0;
 
} catch (PDOException $e) {
  die("Connection failed: " . $e->getMessage());
}
