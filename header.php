<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - Donor List</title>
    <link rel="stylesheet" href="../assets/style.css"> <!-- Update if needed -->
</head>
<body>
<?php include 'admin-navbar.php'; ?>
