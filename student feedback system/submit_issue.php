<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_name = trim($_POST['student_name']);
    $student_id = trim($_POST['student_id']);
    $student_email = trim($_POST['student_email']);
    $category = trim($_POST['category']);
    $description = trim($_POST['description']);
    $status = "Pending";

    $stmt = $conn->prepare("INSERT INTO issues (student_name, student_id, student_email, category, description, status) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $student_name, $student_id, $student_email, $category, $description, $status);

    if ($stmt->execute()) {
        echo "<!DOCTYPE html><html lang='en'><head><meta charset='UTF-8'><meta name='viewport' content='width=device-width, initial-scale=1.0'><title>Success</title><link rel='stylesheet' href='style.css'></head><body class='page-bg'><header class='navbar'><div class='logo-box'><img src='images/logo.png' class='logo-img' alt='Future Builders Logo'><div class='logo-text'><h2>Future Builders</h2><p>Student Feedback and Issue Reporting System</p></div></div></header><section class='form-section'><div class='card'><div class='success'>Issue submitted successfully.</div><h2>Thank you</h2><p>Your issue has been saved in the system.</p><div class='hero-buttons'><a href='report_issue.html' class='btn main-btn'>Submit Another Issue</a><a href='index.html' class='btn secondary-btn'>Go Home</a></div></div></section></body></html>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
