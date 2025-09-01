<?php
session_start();
include 'includes/header.php';
include 'includes/dbconnect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT 
            r.id,
            r.PatientName,
            bg.BloodGroup,
            d.Department,
            r.RequiredDate,
            r.Details,
            r.ContactNo,
            r.RequestDate,
            r.Status,
            r.IsResolved
        FROM tblrequests r
        LEFT JOIN tblbloodgroup bg ON r.BloodGroup = bg.id
        LEFT JOIN tblbaustdpts d ON r.Department = d.id
        WHERE r.UserId = ?
        ORDER BY r.RequestDate DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container mt-5 mb-5">
    <h2 class="text-center mb-4">My Blood Requests</h2>

    <?php if ($result->num_rows > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-danger">
                    <tr>
                        <th>ID</th>
                        <th>Patient Name</th>
                        <th>Blood Group</th>
                        <th>Department</th>
                        <th>Required Date</th>
                        <th>Reason</th>
                        <th>Contact No</th>
                        <th>Request Date</th>
                        <th>Status</th>
                        <th>Resolved</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= htmlspecialchars($row['PatientName']) ?></td>
                            <td><?= htmlspecialchars($row['BloodGroup']) ?></td>
                            <td><?= htmlspecialchars($row['Department']) ?></td>
                            <td><?= htmlspecialchars($row['RequiredDate']) ?></td>
                            <td><?= htmlspecialchars($row['Details']) ?></td>
                            <td><?= htmlspecialchars($row['ContactNo']) ?></td>
                            <td><?= htmlspecialchars($row['RequestDate']) ?></td>
                            <td><?= htmlspecialchars($row['Status']) ?></td>
                            <td><?= $row['IsResolved'] ? 'Yes' : 'No' ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">No blood requests found.</div>
    <?php endif; ?>

</div>

<?php include 'includes/footer.php'; ?>
