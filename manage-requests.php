<?php
session_start();
include('../includes/dbconnect.php');

// Redirect if not logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

// Resolve/unresolve logic
if (isset($_GET['action'], $_GET['id'])) {
    $reqID = intval($_GET['id']);
    $action = $_GET['action'];

    if ($action === 'resolve') {
        mysqli_query($conn, "UPDATE tblrequests SET IsResolved = 1 WHERE id = $reqID");
    } elseif ($action === 'unresolve') {
        mysqli_query($conn, "UPDATE tblrequests SET IsResolved = 0 WHERE id = $reqID");
    }
}

// Fetch request data
$sql = "SELECT r.*, bg.BloodGroup AS BGName, dpt.Department AS DeptName
        FROM tblrequests r
        LEFT JOIN tblbloodgroup bg ON r.BloodGroup = bg.id
        LEFT JOIN tblbaustdpts dpt ON r.Department = dpt.id
        ORDER BY r.RequestDate DESC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Blood Requests - Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include 'admin-navbar.php'; ?>

<div class="container mt-4">
  <h2 class="mb-4 text-center">Manage Blood Donation Requests</h2>

  <?php if ($result && mysqli_num_rows($result) > 0): ?>
    <div class="table-responsive">
      <table class="table table-bordered table-hover align-middle">
        <thead class="table-dark">
          <tr>
            <th>Serial</th>
            <th>Patient Name</th>
            <th>Blood Group</th>
            <th>Department</th>
            <th>Contact No</th>
            <th>Required Date</th>
            <th>Details</th>
            <th>Status</th>
            <th>Resolved</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1; while ($row = mysqli_fetch_assoc($result)) : ?>
            <tr>
              <td><?= $i++; ?></td>
              <td><?= htmlspecialchars($row['PatientName']); ?></td>
              <td><?= htmlspecialchars($row['BGName']); ?></td>
              <td><?= htmlspecialchars($row['DeptName']); ?></td>
              <td><?= htmlspecialchars($row['ContactNo']); ?></td>
              <td><?= htmlspecialchars($row['RequiredDate']); ?></td>
              <td><?= htmlspecialchars($row['Details']); ?></td>
              <td>
                <?php
                  if ($row['Status'] === 'Approved') {
                    $badgeClass = 'bg-success';
                } elseif ($row['Status'] === 'Rejected') {
                    $badgeClass = 'bg-danger';
                } else {
                    $badgeClass = 'bg-warning text-dark';
                }

                ?>
                <span class="badge <?= $badgeClass ?>"><?= $row['Status']; ?></span>
              </td>
              <td>
                <?php if ($row['IsResolved']) : ?>
                  <span class="badge bg-success">Yes</span>
                <?php else : ?>
                  <span class="badge bg-secondary">No</span>
                <?php endif; ?>
              </td>
              <td>
                <?php if ($row['IsResolved']) : ?>
                  <a href="?action=unresolve&id=<?= $row['id']; ?>" class="btn btn-sm btn-warning">Mark Pending</a>
                <?php else : ?>
                  <a href="?action=resolve&id=<?= $row['id']; ?>" class="btn btn-sm btn-success">Mark Resolved</a>
                <?php endif; ?>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="alert alert-info text-center">No blood requests found.</div>
  <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
