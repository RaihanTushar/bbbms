<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

include '../includes/dbconnect.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<script>alert('Invalid access. Donor ID missing.'); window.location.href='donor-list.php';</script>";
    exit();
}
$donor_id = intval($_GET['id']);


// Fetch donor details
$sql = "SELECT * FROM tblblooddonars WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $donor_id);
$stmt->execute();
$result = $stmt->get_result();
$donor = $result->fetch_assoc();

if (!$donor) {
    die("Donor not found.");
}

// Fetch blood groups and departments
$bloodGroups = $conn->query("SELECT * FROM tblbloodgroup");
$departments = $conn->query("SELECT * FROM tblbaustdpts");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = $_POST['fullname'];
    $mobileno = $_POST['mobileno'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $bloodgroup = $_POST['bloodgroup'];
    $department = $_POST['department'];
    $batch = $_POST['batch'];
    $address = $_POST['address'];
    $status = isset($_POST['status']) ? 1 : 0;

    $update = "UPDATE tblblooddonars SET 
        FullName = ?, MobileNumber = ?, Emailid = ?, Gender = ?, Age = ?, 
        BloodGroup = ?, Department = ?, Batch = ?, Address = ?, Status = ?
        WHERE id = ?";
    $stmt = $conn->prepare($update);
    $stmt->bind_param("ssssiiissii", $fullname, $mobileno, $email, $gender, $age,
                      $bloodgroup, $department, $batch, $address, $status, $donor_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<script>alert('Donor updated successfully!'); window.location='donor-list.php';</script>";
    } else {
        echo "<script>alert('No changes made or update failed.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Donor</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-success">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">BAUST BBMS Admin</a>
    <a href="admin-logout.php" class="btn btn-outline-light">Logout</a>
  </div>
</nav>

<div class="container mt-4">
  <h3 class="mb-4">Edit Donor Information</h3>

  <form method="POST">
    <div class="mb-3">
      <label>Full Name</label>
      <input type="text" name="fullname" class="form-control" required value="<?= htmlspecialchars($donor['FullName']) ?>">
    </div>

    <div class="mb-3">
      <label>Mobile Number</label>
      <input type="text" name="mobileno" class="form-control" required value="<?= htmlspecialchars($donor['MobileNumber']) ?>">
    </div>

    <div class="mb-3">
      <label>Email</label>
      <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($donor['Emailid']) ?>">
    </div>

    <div class="mb-3">
      <label>Gender</label>
      <select name="gender" class="form-select">
        <option value="Male" <?= $donor['Gender'] == 'Male' ? 'selected' : '' ?>>Male</option>
        <option value="Female" <?= $donor['Gender'] == 'Female' ? 'selected' : '' ?>>Female</option>
        <option value="Other" <?= $donor['Gender'] == 'Other' ? 'selected' : '' ?>>Other</option>
      </select>
    </div>

    <div class="mb-3">
      <label>Age</label>
      <input type="number" name="age" class="form-control" required value="<?= $donor['Age'] ?>">
    </div>

    <div class="mb-3">
      <label>Blood Group</label>
      <select name="bloodgroup" class="form-select" required>
        <?php while ($bg = $bloodGroups->fetch_assoc()): ?>
          <option value="<?= $bg['id'] ?>" <?= $bg['id'] == $donor['BloodGroup'] ? 'selected' : '' ?>>
            <?= $bg['BloodGroup'] ?>
          </option>
        <?php endwhile; ?>
      </select>
    </div>

    <div class="mb-3">
      <label>Department</label>
      <select name="department" class="form-select" required>
        <?php while ($dept = $departments->fetch_assoc()): ?>
          <option value="<?= $dept['id'] ?>" <?= $dept['id'] == $donor['Department'] ? 'selected' : '' ?>>
            <?= $dept['Department'] ?>
          </option>
        <?php endwhile; ?>
      </select>
    </div>

    <div class="mb-3">
      <label>Batch</label>
      <input type="text" name="batch" class="form-control" value="<?= htmlspecialchars($donor['Batch']) ?>">
    </div>

    <div class="mb-3">
      <label>Address</label>
      <textarea name="address" class="form-control"><?= htmlspecialchars($donor['Address']) ?></textarea>
    </div>

    <div class="form-check mb-3">
      <input class="form-check-input" type="checkbox" name="status" value="1" <?= $donor['Status'] ? 'checked' : '' ?>>
      <label class="form-check-label">Active</label>
    </div>

    <button type="submit" class="btn btn-primary">Update Donor</button>
    <a href="donor-list.php" class="btn btn-secondary">Back</a>
  </form>
</div>

</body>
</html>
