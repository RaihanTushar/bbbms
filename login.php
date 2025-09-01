<?php
session_start();
include '../includes/dbconnect.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = md5($_POST['password']); // basic hash

    $sql = "SELECT * FROM tbladmin WHERE UserName = ? AND Password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows == 1) {
        $row = $res->fetch_assoc();
        $_SESSION['admin_id'] = $row['ID'];
        $_SESSION['admin_name'] = $row['AdminName'];
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid username or password!";
    }
}
?>

<?php include '../includes/header.php'; ?>

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow">
        <div class="card-header bg-danger text-white text-center">
          <h4>Admin Login</h4>
        </div>
        <div class="card-body">
          <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
          <?php endif; ?>
          <form method="POST">
            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-danger w-100">Login</button>
          </form>
          <!-- Register link under the login form -->
          <div class="text-center mt-3">
            <a href="register.php">New Admin? <strong>Register here</strong></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>
