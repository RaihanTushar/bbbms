<?php 
session_start();
include('includes/dbconnect.php');
include('includes/header.php');

$success = '';
$error = '';

// Only allow if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize inputs
    $patientName = trim($_POST['patientName'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $mobile = trim($_POST['mobile'] ?? '');
    $bloodGroup = intval($_POST['blood_group'] ?? 0);
    $department = intval($_POST['department'] ?? 0);
    $batch = trim($_POST['batch'] ?? '');
    $reason = trim($_POST['reason'] ?? '');
    $requiredDate = trim($_POST['requiredDate'] ?? '');
    $userId = $_SESSION['user_id']; // 👉 logged-in user's ID

    // Basic validation
    if (empty($patientName) || empty($email) || empty($mobile) || !$bloodGroup || !$department || empty($reason) || empty($requiredDate)) {
        $error = "Please fill in all required fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } else {
        // Insert into DB with UserId
        $sql = "INSERT INTO tblrequests (PatientName, BloodGroup, Department, RequiredDate, Details, ContactNo, RequestDate, Status, IsResolved, UserId) 
                VALUES (?, ?, ?, ?, ?, ?, NOW(), 'Pending', 0, ?)";

        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("siisssi", $patientName, $bloodGroup, $department, $requiredDate, $reason, $mobile, $userId);
            if ($stmt->execute()) {
                $success = "Your blood donation request has been submitted successfully.";
            } else {
                $error = "Database error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $error = "Database prepare failed: " . $conn->error;
        }
    }
}

// Fetch blood groups and departments for dropdowns
$bloodGroups = $conn->query("SELECT id, BloodGroup FROM tblbloodgroup ORDER BY BloodGroup");
$departments = $conn->query("SELECT id, Department FROM tblbaustdpts ORDER BY Department");
?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Request Blood</h2>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" class="card p-4 shadow-sm">
        <div class="mb-3">
            <label class="form-label" for="patientName">Full Name</label>
            <input type="text" name="patientName" id="patientName" class="form-control" required value="<?= htmlspecialchars($_POST['patientName'] ?? '') ?>" />
        </div>

        <div class="mb-3">
            <label class="form-label" for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" />
        </div>

        <div class="mb-3">
            <label class="form-label" for="mobile">Mobile</label>
            <input type="text" name="mobile" id="mobile" class="form-control" required value="<?= htmlspecialchars($_POST['mobile'] ?? '') ?>" />
        </div>

        <div class="mb-3">
            <label class="form-label" for="blood_group">Blood Group</label>
            <select name="blood_group" id="blood_group" class="form-select" required>
                <option value="">Select Blood Group</option>
                <?php while ($bg = $bloodGroups->fetch_assoc()): ?>
                    <option value="<?= $bg['id'] ?>" <?= (($_POST['blood_group'] ?? '') == $bg['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($bg['BloodGroup']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label" for="department">Department</label>
            <select name="department" id="department" class="form-select" required>
                <option value="">Select Department</option>
                <?php while ($dept = $departments->fetch_assoc()): ?>
                    <option value="<?= $dept['id'] ?>" <?= (($_POST['department'] ?? '') == $dept['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($dept['Department']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label" for="requiredDate">Required Date</label>
            <input type="date" name="requiredDate" id="requiredDate" class="form-control" required value="<?= htmlspecialchars($_POST['requiredDate'] ?? '') ?>" />
        </div>

        <div class="mb-3">
            <label class="form-label" for="reason">Reason for Request</label>
            <textarea name="reason" id="reason" rows="3" class="form-control" required><?= htmlspecialchars($_POST['reason'] ?? '') ?></textarea>
        </div>

        <button type="submit" class="btn btn-danger">Submit Request</button>
    </form>
</div>

<?php include('includes/footer.php'); ?>


