<?php
session_start();
include('../includes/dbconnect.php');  // Adjust path as per your project

// Redirect if admin not logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs
    $fullName = trim($_POST['FullName']);
    $mobileNumber = trim($_POST['MobileNumber']);
    $email = trim($_POST['Emailid']);
    $gender = $_POST['Gender'] ?? '';
    $age = intval($_POST['Age']);
    $bloodGroup = $_POST['BloodGroup'] ?? '';
    $department = $_POST['Department'] ?? '';
    $batch = trim($_POST['Batch']);
    $address = trim($_POST['Address']);
    $status = isset($_POST['Status']) ? 1 : 0;
    $password = $_POST['Password'] ?? '';

    // Validation
    if (empty($fullName)) $errors[] = "Full Name is required.";
    if (!preg_match('/^\+?\d{7,15}$/', $mobileNumber)) $errors[] = "Enter a valid Mobile Number.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Enter a valid Email.";
    if (!in_array($gender, ['Male', 'Female', 'Other'])) $errors[] = "Select a valid Gender.";
    if ($age < 18 || $age > 70) $errors[] = "Age must be between 18 and 70.";
    if (empty($bloodGroup)) $errors[] = "Select Blood Group.";
    if (empty($department)) $errors[] = "Select Department.";
    if (empty($batch)) $errors[] = "Batch is required.";
    if (empty($address)) $errors[] = "Address is required.";
    if (strlen($password) < 6) $errors[] = "Password must be at least 6 characters.";

    // Check for duplicate email or mobile
    $stmt = $conn->prepare("SELECT id FROM tblblooddonars WHERE Emailid = ? OR MobileNumber = ?");
    $stmt->bind_param("ss", $email, $mobileNumber);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $errors[] = "Mobile number or Email already registered.";
    }
    $stmt->close();

    // Insert if no errors
    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO tblblooddonars 
            (FullName, MobileNumber, Emailid, Gender, Age, BloodGroup, Department, Batch, Address, Status, Password, PostingDate) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("ssssisssssi", $fullName, $mobileNumber, $email, $gender, $age, $bloodGroup, $department, $batch, $address, $status, $hashedPassword);

        if ($stmt->execute()) {
            $success = "Donor added successfully!";
            $_POST = [];  // Clear form after success
        } else {
            $errors[] = "Database error: Could not add donor.";
        }
        $stmt->close();
    }
}

// Fetch blood groups and departments for selects
$bloodGroupsRes = $conn->query("SELECT id, BloodGroup FROM tblbloodgroup ORDER BY BloodGroup");
$departmentsRes = $conn->query("SELECT id, Department FROM tblbaustdpts ORDER BY Department");

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Add Donor - Admin Panel</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-success">
  <?php include 'admin-navbar.php'; ?>
</nav>

<div class="container mt-4">
  <h2 class="mb-4 text-center">Add New Donor</h2>

  <?php if ($success): ?>
    <div class="alert alert-success"><?= $success ?></div>
  <?php endif; ?>

  <?php if ($errors): ?>
    <div class="alert alert-danger">
      <ul>
        <?php foreach ($errors as $e): ?>
          <li><?= htmlspecialchars($e) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form method="post" novalidate>
    <div class="mb-3">
      <label for="FullName" class="form-label">Full Name</label>
      <input type="text" class="form-control" id="FullName" name="FullName" value="<?= htmlspecialchars($_POST['FullName'] ?? '') ?>" required>
    </div>

    <div class="mb-3">
      <label for="MobileNumber" class="form-label">Mobile Number</label>
      <input type="text" class="form-control" id="MobileNumber" name="MobileNumber" value="<?= htmlspecialchars($_POST['MobileNumber'] ?? '') ?>" required>
    </div>

    <div class="mb-3">
      <label for="Emailid" class="form-label">Email address</label>
      <input type="email" class="form-control" id="Emailid" name="Emailid" value="<?= htmlspecialchars($_POST['Emailid'] ?? '') ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Gender</label><br>
      <?php
      $genders = ['Male', 'Female', 'Other'];
      foreach ($genders as $g) {
          $checked = (($_POST['Gender'] ?? '') === $g) ? 'checked' : '';
          echo "<div class='form-check form-check-inline'>
                  <input class='form-check-input' type='radio' name='Gender' id='gender_$g' value='$g' $checked required>
                  <label class='form-check-label' for='gender_$g'>$g</label>
                </div>";
      }
      ?>
    </div>

    <div class="mb-3">
      <label for="Age" class="form-label">Age</label>
      <input type="number" min="18" max="70" class="form-control" id="Age" name="Age" value="<?= htmlspecialchars($_POST['Age'] ?? '') ?>" required>
    </div>

    <div class="mb-3">
      <label for="BloodGroup" class="form-label">Blood Group</label>
      <select class="form-select" id="BloodGroup" name="BloodGroup" required>
        <option value="">Select Blood Group</option>
        <?php while ($bg = $bloodGroupsRes->fetch_assoc()): ?>
          <option value="<?= $bg['id'] ?>" <?= (($_POST['BloodGroup'] ?? '') == $bg['id']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($bg['BloodGroup']) ?>
          </option>
        <?php endwhile; ?>
      </select>
    </div>

    <div class="mb-3">
      <label for="Department" class="form-label">Department</label>
      <select class="form-select" id="Department" name="Department" required>
        <option value="">Select Department</option>
        <?php while ($dept = $departmentsRes->fetch_assoc()): ?>
          <option value="<?= $dept['id'] ?>" <?= (($_POST['Department'] ?? '') == $dept['id']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($dept['Department']) ?>
          </option>
        <?php endwhile; ?>
      </select>
    </div>

    <div class="mb-3">
      <label for="Batch" class="form-label">Batch</label>
      <input type="text" class="form-control" id="Batch" name="Batch" value="<?= htmlspecialchars($_POST['Batch'] ?? '') ?>" required>
    </div>

    <div class="mb-3">
      <label for="Address" class="form-label">Address</label>
      <textarea class="form-control" id="Address" name="Address" rows="3" required><?= htmlspecialchars($_POST['Address'] ?? '') ?></textarea>
    </div>

    <div class="mb-3 form-check">
      <input type="checkbox" class="form-check-input" id="Status" name="Status" <?= isset($_POST['Status']) ? 'checked' : '' ?>>
      <label class="form-check-label" for="Status">Active Status</label>
    </div>

    <div class="mb-3">
      <label for="Password" class="form-label">Password (min 6 chars)</label>
      <input type="password" class="form-control" id="Password" name="Password" required>
    </div>

    <button type="submit" class="btn btn-success">Add Donor</button>
  </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


