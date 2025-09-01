<?php include 'includes/dbconnect.php'; ?>
<?php include 'includes/header.php'; ?>

<!-- Page Content with Background -->
<div class="content-background" style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('assets/images/bloodbank2.jpg') no-repeat center center fixed; background-size: cover; padding: 60px 0;">

  <!-- Hero Section -->
  <div class="container">
    <div class="row align-items-center text-white">
      <div class="col-md-7">
        <h1 class="display-4 fw-bold mb-3 animate__animated animate__fadeInDown">BAUST Blood Bank</h1>
        <p class="lead mb-4 animate__animated animate__fadeInUp">Give the gift of life – Donate blood, save lives. Your contribution can be someone's hope.</p>
        <a href="register.php" class="btn btn-danger btn-lg me-3 animate__animated animate__fadeInLeft">Become a Donor</a>
        <a href="login.php" class="btn btn-outline-light btn-lg animate__animated animate__fadeInRight">Request Blood</a>
      </div>
      
    </div>
  </div>

</div>

<!-- Features Section -->
<div class="container mt-5 mb-5">
  <h2 class="text-center mb-5 fw-bold text-danger">Our Key Features</h2>
  <div class="row text-center">
    <div class="col-md-4 mb-4">
      <div class="card shadow h-100 border-0 animate__animated animate__fadeInUp">
        <div class="card-body">
          <div class="mb-3">
            <i class="bi bi-search-heart display-4 text-primary"></i>
          </div>
          <h5 class="card-title fw-bold">Search Donors</h5>
          <p class="card-text">Quickly find compatible blood donors across departments and groups.</p>
          <a href="login.php" class="btn btn-outline-primary mt-2">Search</a>
        </div>
      </div>
    </div>
    <div class="col-md-4 mb-4">
      <div class="card shadow h-100 border-0 animate__animated animate__fadeInUp delay-1s">
        <div class="card-body">
          <div class="mb-3">
            <i class="bi bi-people-fill display-4 text-success"></i>
          </div>
          <h5 class="card-title fw-bold">View Donor List</h5>
          <p class="card-text">See active and available donors for emergencies and support.</p>
          <a href="login.php" class="btn btn-outline-success mt-2">Donor List</a>
        </div>
      </div>
    </div>
    <div class="col-md-4 mb-4">
      <div class="card shadow h-100 border-0 animate__animated animate__fadeInUp delay-2s">
        <div class="card-body">
          <div class="mb-3">
            <i class="bi bi-person-lock display-4 text-secondary"></i>
          </div>
          <h5 class="card-title fw-bold">Admin Panel</h5>
          <p class="card-text">Admins can securely manage donors, requests, and analytics.</p>
          <a href="admin/login.php" class="btn btn-outline-secondary mt-2">Admin Login</a>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
