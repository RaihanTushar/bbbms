<?php
include 'includes/dbconnect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Search Donor - BAUST BBMS</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-success">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">BAUST BBMS</a>
    <div>
      <a href="login.php" class="btn btn-outline-light">Login</a>
    </div>
  </div>
</nav>

<div class="container mt-4">
  <h3 class="mb-4">Search Blood Donors</h3>

  <form method="GET" action="search-donor.php">
    <div class="row mb-3">
      <div class="col-md-4">
        <label for="bloodgroup" class="form-label">Select Blood Group</label>
        <select class="form-select" name="bloodgroup" id="bloodgroup" required>
          <option value="">-- Select --</option>
          <?php
          $bgQuery = "SELECT * FROM tblbloodgroup";
          $bgResult = mysqli_query($conn, $bgQuery);
          while ($row = mysqli_fetch_assoc($bgResult)) {
              echo "<option value='{$row['id']}'>{$row['BloodGroup']}</option>";
          }
          ?>
        </select>
      </div>

      <div class="col-md-4">
        <label for="department" class="form-label">Select Department</label>
        <select class="form-select" name="department" id="department" required>
          <option value="">-- Select --</option>
          <?php
          $deptQuery = "SELECT * FROM tblbaustdpts";
          $deptResult = mysqli_query($conn, $deptQuery);
          while ($row = mysqli_fetch_assoc($deptResult)) {
              echo "<option value='{$row['id']}'>{$row['Department']}</option>";
          }
          ?>
        </select>
      </div>

      <div class="col-md-4 align-self-end">
        <button type="submit" class="btn btn-primary">Search</button>
      </div>
    </div>
  </form>

  <?php
  if (isset($_GET['bloodgroup']) && isset($_GET['department'])) {
    $bgId = $_GET['bloodgroup'];
    $deptId = $_GET['department'];

    $sql = "SELECT d.FullName, d.MobileNumber, d.Emailid, bg.BloodGroup, dept.Department
            FROM tblblooddonars d
            LEFT JOIN tblbloodgroup bg ON d.BloodGroup = bg.id
            LEFT JOIN tblbaustdpts dept ON d.Department = dept.id
            WHERE d.BloodGroup = '$bgId' AND d.Department = '$deptId' AND d.Status = 1";

    $result = mysqli_query($conn, $sql);

    echo "<h5 class='mt-4'>Search Results:</h5>";

    if ($result && mysqli_num_rows($result) > 0) {
      echo "<table class='table table-bordered table-hover mt-3'>";
      echo "<thead><tr><th>Name</th><th>Mobile</th><th>Email</th><th>Blood Group</th><th>Department</th></tr></thead><tbody>";
      while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['FullName']) . "</td>";
        echo "<td>" . htmlspecialchars($row['MobileNumber']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Emailid']) . "</td>";
        echo "<td>" . htmlspecialchars($row['BloodGroup']) . "</td>";
        echo "<td>" . htmlspecialchars($row['Department']) . "</td>";
        echo "</tr>";
      }
      echo "</tbody></table>";
    } else {
      echo "<div class='alert alert-warning mt-3'>No donors found for selected criteria.</div>";
    }
  }
  ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
