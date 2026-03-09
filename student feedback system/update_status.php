<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}
include 'db_connect.php';
include 'config_email.php';

if (!isset($_GET['id'])) {
    header("Location: view_issues.php");
    exit();
}

$id = (int)$_GET['id'];

function sendSolvedEmail($to, $studentName, $category, $from_email, $from_name) {
    $subject = "Issue Status Updated - Solved";
    $message = "Hello " . $studentName . "\n\n" .
               "Your reported issue related to " . $category . " has been marked as Solved.\n\n" .
               "Thank you,\n" . $from_name;
    $headers = "From: " . $from_name . " <" . $from_email . ">\r\n";
    $headers .= "Reply-To: " . $from_email . "\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();
    return mail($to, $subject, $message, $headers);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE issues SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $new_status, $id);
    $stmt->execute();
    $stmt->close();

    if ($new_status === "Solved") {
        $mailStmt = $conn->prepare("SELECT student_name, student_email, category FROM issues WHERE id = ?");
        $mailStmt->bind_param("i", $id);
        $mailStmt->execute();
        $mailResult = $mailStmt->get_result();
        $issueData = $mailResult->fetch_assoc();
        $mailStmt->close();

        if ($issueData) {
            sendSolvedEmail(
                $issueData['student_email'],
                $issueData['student_name'],
                $issueData['category'],
                $from_email,
                $from_name
            );
        }
    }

    header("Location: view_issues.php");
    exit();
}

$stmt = $conn->prepare("SELECT * FROM issues WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$issue = $result->fetch_assoc();
$stmt->close();

if (!$issue) {
    header("Location: view_issues.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Update Status</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body class="page-bg">
  <header class="navbar">
    <div class="logo-box">
      <img src="images/logo.png" class="logo-img" alt="Future Builders Logo">
      <div class="logo-text">
        <h2>Future Builders</h2>
        <p>Student Feedback and Issue Reporting System</p>
      </div>
    </div>
  </header>

  <section class="form-section">
    <div class="form-container">
      <div class="form-left">
        <span class="tagline">Admin Update</span>
        <h1>Update Issue Status</h1>
        <p>Review the selected issue and change the status to keep the system updated.</p>
        <div class="info-list">
          <div class="info-item"><b>Student:</b> <?php echo htmlspecialchars($issue['student_name']); ?></div>
          <div class="info-item"><b>Email:</b> <?php echo htmlspecialchars($issue['student_email']); ?></div>
          <div class="info-item"><b>Category:</b> <?php echo htmlspecialchars($issue['category']); ?></div>
          <div class="info-item"><b>Description:</b> <?php echo htmlspecialchars($issue['description']); ?></div>
        </div>
      </div>

      <div class="form-card">
        <div class="form-header">
          <h2>Status Form</h2>
          <p>If you select Solved, the system will try to send an email to the student.</p>
        </div>

        <form method="POST" action="">
          <label for="status">Status</label>
          <select id="status" name="status" required>
            <option value="Pending" <?php if ($issue['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
            <option value="In Progress" <?php if ($issue['status'] == 'In Progress') echo 'selected'; ?>>In Progress</option>
            <option value="Solved" <?php if ($issue['status'] == 'Solved') echo 'selected'; ?>>Solved</option>
          </select>

          <div class="hero-buttons">
            <button type="submit" class="btn main-btn">Update Status</button>
            <a href="view_issues.php" class="btn secondary-btn">Back</a>
          </div>
        </form>
      </div>
    </div>
  </section>
</body>
</html>
