<?php 
include 'includes/dbconnect.php';
include 'includes/header.php';

$success = '';
$error = '';

if (isset($_POST['submit'])) {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

    if ($name && $email && $subject && $message) {
        $sql = "INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ssss", $name, $email, $subject, $message);
            $stmt->execute();
            $success = "Message sent successfully!";
        } else {
            $error = "Failed to send message. Try again.";
        }
    } else {
        $error = "Please fill out all fields.";
    }
}
?>

<div class="container mt-5 mb-5">
  <div class="row">
    <!-- Contact Form -->
    <div class="col-md-7">
      <div class="card shadow">
        <div class="card-header bg-danger text-white">
          <h4>Contact Us</h4>
        </div>
        <div class="card-body">
          <?php if ($success): ?>
            <div class="alert alert-success"><?= $success ?></div>
          <?php elseif ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
          <?php endif; ?>
          <form method="POST">
            <div class="mb-3">
              <label class="form-label">Name</label>
              <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Subject</label>
              <input type="text" name="subject" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Message</label>
              <textarea name="message" class="form-control" rows="5" required></textarea>
            </div>
            <button type="submit" name="submit" class="btn btn-danger">Send Message</button>
          </form>
        </div>
      </div>
    </div>

    <!-- Contact Info -->
    <div class="col-md-5">
      <div class="card shadow mb-3">
        <div class="card-body">
          <h5 class="text-danger">BAUST Blood Bank</h5>
          <p><strong>Address:</strong> Saidpur Cantonment, Nilphamari, Bangladesh</p>
          <p><strong>Phone:</strong> +8801XXXXXXXXX</p>
          <p><strong>Email:</strong> support@baustbloodbank.com</p>
          <div>
            <strong>Follow us:</strong><br>
            <a href="https://www.facebook.com/share/g/16qgUMCVSK/" target="_blank">Facebook</a> |
            <a href="#" target="_blank">Twitter</a> |
            <a href="#" target="_blank">Instagram</a>
          </div>
        </div>
      </div>

      <!-- Google Map -->
      <div class="card shadow">
        <div class="card-body p-0">
          <iframe 
            src="https://www.google.com/maps?q=Bangladesh+Army+University+of+Science+and+Technology+Saidpur&output=embed" 
            width="100%" 
            height="250" 
            frameborder="0" 
            style="border:0;" 
            allowfullscreen>
          </iframe>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
