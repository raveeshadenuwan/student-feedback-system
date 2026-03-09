<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}
include 'db_connect.php';

$total_result = $conn->query("SELECT COUNT(*) AS total FROM issues");
$total_issues = $total_result->fetch_assoc()['total'];
$pending_result = $conn->query("SELECT COUNT(*) AS total FROM issues WHERE status = 'Pending'");
$pending_issues = $pending_result->fetch_assoc()['total'];
$progress_result = $conn->query("SELECT COUNT(*) AS total FROM issues WHERE status = 'In Progress'");
$progress_issues = $progress_result->fetch_assoc()['total'];
$solved_result = $conn->query("SELECT COUNT(*) AS total FROM issues WHERE status = 'Solved'");
$solved_issues = $solved_result->fetch_assoc()['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body class="dashboard-body">
  <div class="sidebar">
    <div class="sidebar-logo">
      <img src="images/logo.png" alt="Future Builders Logo">
      <div class="sidebar-logo-text">
        <h2>Future Builders</h2>
        <p>Admin Panel</p>
      </div>
    </div>

    <ul class="sidebar-menu">
      <li><a href="admin_dashboard.php" class="active">🏠 Dashboard</a></li>
      <li><a href="view_issues.php">📋 View Issues</a></li>
      <li><a href="report_issue.html">📝 Report Form</a></li>
      <li><a href="logout.php">🚪 Logout</a></li>
    </ul>
  </div>

  <div class="main-content">
    <div class="top-header">
      <h1>Admin Dashboard</h1>
      <p>Welcome, <b><?php echo htmlspecialchars($_SESSION['admin_username']); ?></b></p>
    </div>

    <div class="dashboard-cards">
      <div class="dashboard-card"><h3>Total Issues</h3><p><?php echo $total_issues; ?></p></div>
      <div class="dashboard-card pending-card"><h3>Pending</h3><p><?php echo $pending_issues; ?></p></div>
      <div class="dashboard-card progress-card"><h3>In Progress</h3><p><?php echo $progress_issues; ?></p></div>
      <div class="dashboard-card solved-card"><h3>Solved</h3><p><?php echo $solved_issues; ?></p></div>
    </div>

    <div class="dashboard-actions">
      <a href="view_issues.php" class="btn main-btn">View All Issues</a>
      <a href="logout.php" class="btn secondary-btn">Logout</a>
    </div>

    <div class="dashboard-box">
      <h2>System Summary</h2>
      <p>This dashboard helps the admin monitor all reported campus issues. The admin can check pending issues, track issues in progress, and see solved issues quickly.</p>
    </div>
  </div>
</body>
</html>
