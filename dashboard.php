<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

include '../includes/dbconnect.php';
include 'header.php'; // only if header.php exists and does not start session again

// Stats
$totalDonors = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total FROM tblblooddonars"))['total'];
$activeDonors = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS active FROM tblblooddonars WHERE Status=1"))['active'];
$inactiveDonors = $totalDonors - $activeDonors;

// Blood Group Distribution
$bloodGroupData = [];
$bgQuery = mysqli_query($conn, "SELECT bg.BloodGroup, COUNT(d.id) AS count
                                FROM tblblooddonars d
                                LEFT JOIN tblbloodgroup bg ON d.BloodGroup = bg.id
                                GROUP BY d.BloodGroup");
while ($row = mysqli_fetch_assoc($bgQuery)) {
    $bloodGroupData[] = $row;
}

// Department Distribution
$deptData = [];
$deptQuery = mysqli_query($conn, "SELECT dept.Department, COUNT(d.id) AS count
                                  FROM tblblooddonars d
                                  LEFT JOIN tblbaustdpts dept ON d.Department = dept.id
                                  GROUP BY d.Department");
while ($row = mysqli_fetch_assoc($deptQuery)) {
    $deptData[] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard - Analytics</title>
  <meta charset="UTF-8">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>



<div class="container mt-4">
  <h3 class="mb-4">Admin Dashboard Analytics</h3>

  <div class="row text-center mb-4">
    <div class="col-md-4">
      <div class="card bg-info text-white">
        <div class="card-body">
          <h5>Total Donors</h5>
          <h2><?= $totalDonors ?></h2>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card bg-success text-white">
        <div class="card-body">
          <h5>Active Donors</h5>
          <h2><?= $activeDonors ?></h2>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card bg-danger text-white">
        <div class="card-body">
          <h5>Inactive Donors</h5>
          <h2><?= $inactiveDonors ?></h2>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <!-- Blood Group Chart -->
    <div class="col-md-6 mb-4">
      <h5>Donors by Blood Group</h5>
      <canvas id="bloodGroupChart"></canvas>
    </div>

    <!-- Department Chart -->
    <div class="col-md-6 mb-4">
      <h5>Donors by Department</h5>
      <canvas id="departmentChart"></canvas>
    </div>
  </div>
</div>

<script>
const bgLabels = <?= json_encode(array_column($bloodGroupData, 'BloodGroup')) ?>;
const bgCounts = <?= json_encode(array_column($bloodGroupData, 'count')) ?>;
const deptLabels = <?= json_encode(array_column($deptData, 'Department')) ?>;
const deptCounts = <?= json_encode(array_column($deptData, 'count')) ?>;

new Chart(document.getElementById('bloodGroupChart'), {
  type: 'bar',
  data: {
    labels: bgLabels,
    datasets: [{
      label: 'Blood Group',
      data: bgCounts,
      backgroundColor: 'rgba(255, 99, 132, 0.6)',
      borderColor: 'rgba(255, 99, 132, 1)',
      borderWidth: 1
    }]
  }
});

new Chart(document.getElementById('departmentChart'), {
  type: 'bar',
  data: {
    labels: deptLabels,
    datasets: [{
      label: 'Department',
      data: deptCounts,
      backgroundColor: 'rgba(54, 162, 235, 0.6)',
      borderColor: 'rgba(54, 162, 235, 1)',
      borderWidth: 1
    }]
  }
});
</script>

</body>
</html>

