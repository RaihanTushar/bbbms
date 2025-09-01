<?php
include('../includes/dbconnect.php');
include('../includes/header.php');

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $adminName = $_POST['adminName'];
    $userName = $_POST['userName'];
    $mobileNumber = $_POST['mobileNumber'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Secure password

    // Check if username or email exists
    $check = mysqli_query($conn, "SELECT * FROM tbladmin WHERE UserName='$userName' OR Email='$email'");
    if (mysqli_num_rows($check) > 0) {
        $msg = "⚠️ Username or Email already exists!";
    } else {
        $query = "INSERT INTO tbladmin (AdminName, UserName, MobileNumber, Email, Password) 
                  VALUES ('$adminName', '$userName', '$mobileNumber', '$email', '$password')";
        if (mysqli_query($conn, $query)) {
            $msg = "✅ Admin registered successfully!";
        } else {
            $msg = "❌ Registration failed: " . mysqli_error($conn);
        }
    }
}
?>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-danger text-white text-center">
                    <h4>Admin Registration</h4>
                </div>
                <div class="card-body">
                    <?php if ($msg): ?>
                        <div class="alert alert-info text-center"><?php echo $msg; ?></div>
                    <?php endif; ?>
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label class="form-label">Admin Name</label>
                            <input type="text" name="adminName" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="userName" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mobile Number</label>
                            <input type="text" name="mobileNumber" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-danger w-100">Register</button>
                    </form>
                    <div class="text-center mt-3">
                        <a href="login.php">Already registered? Login here</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../includes/footer.php'); ?>

