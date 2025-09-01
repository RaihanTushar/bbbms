<?php
session_start();
include 'includes/header.php';
include 'includes/dbconnect.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['user_id'];

// Get user email for image update
$queryEmail = $conn->prepare("SELECT Emailid FROM tblblooddonars WHERE id = ?");
$queryEmail->bind_param("i", $userId);
$queryEmail->execute();
$queryEmail->bind_result($userEmail);
$queryEmail->fetch();
$queryEmail->close();

// Handle image upload
if (isset($_POST['upload_image']) && isset($_FILES['profile_image'])) {
    $img = $_FILES['profile_image'];
    $imgName = basename($img['name']);
    $imgTmp = $img['tmp_name'];
    $imgExt = strtolower(pathinfo($imgName, PATHINFO_EXTENSION));

    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
    if (in_array($imgExt, $allowed)) {
        $newName = "uploads/" . uniqid('profile_') . "." . $imgExt;
        if (move_uploaded_file($imgTmp, $newName)) {
            $update = $conn->prepare("UPDATE tblblooddonars SET ProfileImage = ? WHERE Emailid = ?");
            $update->bind_param("ss", $newName, $userEmail);
            $update->execute();
            $_SESSION['success_msg'] = "Profile picture updated successfully!";
            header("Location: user-dashboard.php");
            exit;
        } else {
            $_SESSION['error_msg'] = "Upload failed. Try again.";
        }
    } else {
        $_SESSION['error_msg'] = "Only JPG, PNG, or GIF files are allowed.";
    }
}

// Fetch user profile with blood group and department names
$sql = "SELECT d.id, d.FullName, d.Emailid, d.MobileNumber, d.Gender, d.Age, d.Address, d.Batch, d.Message, d.PostingDate, 
        d.ProfileImage, bg.BloodGroup, dept.Department 
        FROM tblblooddonars d
        JOIN tblbloodgroup bg ON d.BloodGroup = bg.id
        JOIN tblbaustdpts dept ON d.Department = dept.id
        WHERE d.id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$donor = $result->fetch_assoc();
$stmt->close();
?>

<div class="container mt-5 mb-5">

  <?php if (isset($_SESSION['success_msg'])): ?>
    <div class="alert alert-success text-center"><?= $_SESSION['success_msg']; unset($_SESSION['success_msg']); ?></div>
  <?php endif; ?>

  <?php if (isset($_SESSION['error_msg'])): ?>
    <div class="alert alert-danger text-center"><?= $_SESSION['error_msg']; unset($_SESSION['error_msg']); ?></div>
  <?php endif; ?>

  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow">
        <div class="card-header bg-danger text-white text-center">
          <h4>Welcome, <?= htmlspecialchars($donor['FullName']) ?>!</h4>
        </div>

        <div class="card-body text-center">

          <!-- Profile Image -->
          <img src="<?= htmlspecialchars($donor['ProfileImage']) ?>" class="rounded-circle mb-3" width="150" height="150" style="object-fit: cover; border: 3px solid #dc3545;">

          <!-- Upload Form -->
          <form method="POST" enctype="multipart/form-data" class="mb-3">
            <input type="file" name="profile_image" class="form-control mb-2" required accept="image/*">
            <button type="submit" name="upload_image" class="btn btn-sm btn-outline-danger">Upload New Picture</button>
          </form>

          <!-- Donor Info -->
          <ul class="list-group text-start">
            <li class="list-group-item"><strong>Email:</strong> <?= htmlspecialchars($donor['Emailid']) ?></li>
            <li class="list-group-item"><strong>Mobile:</strong> <?= htmlspecialchars($donor['MobileNumber']) ?></li>
            <li class="list-group-item"><strong>Gender:</strong> <?= htmlspecialchars($donor['Gender']) ?></li>
            <li class="list-group-item"><strong>Age:</strong> <?= htmlspecialchars($donor['Age']) ?></li>
            <li class="list-group-item"><strong>Blood Group:</strong> <?= htmlspecialchars($donor['BloodGroup']) ?></li>
            <li class="list-group-item"><strong>Department:</strong> <?= htmlspecialchars($donor['Department']) ?></li>
            <li class="list-group-item"><strong>Batch:</strong> <?= htmlspecialchars($donor['Batch']) ?></li>
            <li class="list-group-item"><strong>Address:</strong> <?= htmlspecialchars($donor['Address']) ?></li>
            <li class="list-group-item"><strong>Message:</strong> <?= htmlspecialchars($donor['Message']) ?></li>
          </ul>

        </div>
      </div>

      <div class="list-group mt-4 shadow">
        <a href="my-requests.php" class="list-group-item list-group-item-action">My Blood Requests</a>
        <a href="donor-list.php" class="list-group-item list-group-item-action">View Donor List</a>
        <a href="search-donor.php" class="list-group-item list-group-item-action">Search for Donors</a>
        <a href="request-blood.php" class="list-group-item list-group-item-action">Request Blood</a>
        <a href="logout.php" class="list-group-item list-group-item-action text-danger fw-bold">Logout</a>
      </div>

    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
