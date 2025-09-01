<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

include '../includes/dbconnect.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $donor_id = intval($_GET['id']);

    // First check if the donor exists
    $check_sql = "SELECT id FROM tblblooddonars WHERE id = $donor_id";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        // Delete the donor
        $delete_sql = "DELETE FROM tblblooddonars WHERE id = $donor_id";
        if (mysqli_query($conn, $delete_sql)) {
            $_SESSION['msg'] = "Donor deleted successfully.";
        } else {
            $_SESSION['msg'] = "Error deleting donor.";
        }
    } else {
        $_SESSION['msg'] = "Donor not found.";
    }
} else {
    $_SESSION['msg'] = "Invalid donor ID.";
}

// Redirect back to the donor list
header("Location: donor-list.php");
exit();
?>
