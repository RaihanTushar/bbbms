<?php
include 'header.php';
include '../includes/dbconnect.php';
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow border-0">
                <div class="card-header bg-danger text-white text-center">
                    <h4>📩 Contact Messages</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Subject</th>
                                    <th>Message</th>
                                    <th>Submitted At</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT * FROM contact_messages ORDER BY created_at DESC";
                                $result = $conn->query($sql);
                                $count = 1;

                                if ($result && $result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $count++ . "</td>";
                                        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['subject']) . "</td>";
                                        echo "<td>" . nl2br(htmlspecialchars($row['message'])) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['created_at']) . "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='6' class='text-center text-muted'>No messages found.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer text-center text-muted">
                    &copy; 2025 BAUST Blood Bank Management System. All Rights Reserved.<br>
                    Developed by CSE Students, BAUST
                </div>
            </div>
        </div>
    </div>
</div>


