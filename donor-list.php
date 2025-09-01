<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}
include '../includes/dbconnect.php';
include 'header.php'; // Ensure this file starts AFTER session_start
// Fetch donors with department and blood group names
$sql = "SELECT d.id, d.FullName, d.MobileNumber, d.Emailid, d.Gender, d.Age,
        bg.BloodGroup, dept.Department, d.Batch, d.Address, d.Status, d.PostingDate
        FROM tblblooddonars d
        LEFT JOIN tblbloodgroup bg ON d.BloodGroup = bg.id
        LEFT JOIN tblbaustdpts dept ON d.Department = dept.id
        ORDER BY d.PostingDate DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Donor List - Admin Panel</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>



<div class="container mt-4">
  <h2 class="mb-4">Donor List</h2>
  <?php if (isset($_SESSION['msg'])): ?>
  <div class="alert alert-info alert-dismissible fade show" role="alert">
    <?= $_SESSION['msg'] ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  <?php unset($_SESSION['msg']); ?>
<?php endif; ?>


  <?php if ($result && $result->num_rows > 0): ?>
    <table class="table table-bordered table-striped table-hover">
      <thead class="table-success">
        <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Mobile</th>
            <th>Email</th>
            <th>Gender</th>
            <th>Age</th>
            <th>Blood Group</th>
            <th>Department</th>
            <th>Batch</th>
            <th>Address</th>
            <th>Status</th>
            <th>Registered On</th>
            <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($donor = $result->fetch_assoc()): ?>
          <tr>
            <td><?= $donor['id'] ?></td>
            <td><?= htmlspecialchars($donor['FullName']) ?></td>
            <td><?= htmlspecialchars($donor['MobileNumber']) ?></td>
            <td><?= htmlspecialchars($donor['Emailid']) ?></td>
            <td><?= htmlspecialchars($donor['Gender']) ?></td>
            <td><?= $donor['Age'] ?></td>
            <td><?= htmlspecialchars($donor['BloodGroup'] ?? 'N/A') ?></td>
            <td><?= htmlspecialchars($donor['Department'] ?? 'N/A') ?></td>
            <td><?= htmlspecialchars($donor['Batch']) ?></td>
            <td><?= htmlspecialchars($donor['Address']) ?></td>
            <td><?= $donor['Status'] ? 'Active' : 'Inactive' ?></td>
            <td><?= $donor['PostingDate'] ?></td>
            <td>
              <a href="edit-donor.php?id=<?= $donor['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
              <a href="delete-donor.php?id=<?= $donor['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this donor?');">Delete</a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p>No donors found.</p>
  <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>





