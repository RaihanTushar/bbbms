<?php
include 'includes/dbconnect.php';
include 'includes/header.php';

// Fetch all blood requests
$sql = "SELECT * FROM tblbloodrequirer ORDER BY ApplyDate DESC";
$result = mysqli_query($conn, $sql);
?>

<div class="container mt-5">
  <h3 class="text-danger mb-4">All Blood Requests</h3>
  <?php if (mysqli_num_rows($result) > 0): ?>
  <div class="table-responsive">
    <table class="table table-bordered table-striped">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Blood Group</th>
          <th>Contact Number</th>
          <th>Email</th>
          <th>Reason</th>
          <th>Message</th>
          <th>Apply Date</th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
          <td><?= $i++; ?></td>
          <td><?= htmlspecialchars($row['name']); ?></td>
          <td><?= htmlspecialchars($row['BloodGroup']); ?></td>
          <td><?= htmlspecialchars($row['ContactNumber']); ?></td>
          <td><?= htmlspecialchars($row['Emailid']); ?></td>
          <td><?= htmlspecialchars($row['BloodRequirefor']); ?></td>
          <td><?= htmlspecialchars($row['Message']); ?></td>
          <td><?= date("d M Y", strtotime($row['ApplyDate'])); ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
  <?php else: ?>
    <p class="text-muted">No blood requests found.</p>
  <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
