<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}
include 'db_connect.php';
$result = $conn->query("SELECT * FROM issues ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>View Issues</title>
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
      <li><a href="admin_dashboard.php">🏠 Dashboard</a></li>
      <li><a href="view_issues.php" class="active">📋 View Issues</a></li>
      <li><a href="report_issue.html">📝 Report Form</a></li>
      <li><a href="logout.php">🚪 Logout</a></li>
    </ul>
  </div>

  <div class="main-content">
    <div class="top-header">
      <h1>All Reported Issues</h1>
      <p>Admin can review and update each issue from this table.</p>
    </div>

    <div class="dashboard-actions">
      <a href="admin_dashboard.php" class="btn main-btn">Back to Dashboard</a>
      <a href="logout.php" class="btn secondary-btn">Logout</a>
    </div>

    <div class="table-card">
      <table>
        <tr>
          <th>ID</th>
          <th>Student Name</th>
          <th>Student ID</th>
          <th>Email</th>
          <th>Category</th>
          <th>Description</th>
          <th>Status</th>
          <th>Date</th>
          <th>Action</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?php echo $row['id']; ?></td>
          <td><?php echo htmlspecialchars($row['student_name']); ?></td>
          <td><?php echo htmlspecialchars($row['student_id']); ?></td>
          <td><?php echo htmlspecialchars($row['student_email']); ?></td>
          <td><?php echo htmlspecialchars($row['category']); ?></td>
          <td><?php echo htmlspecialchars($row['description']); ?></td>
          <td>
            <?php
              $status = $row['status'];
              $class = 'pending';
              if ($status == 'In Progress') $class = 'progress';
              if ($status == 'Solved') $class = 'solved';
            ?>
            <span class="status-badge <?php echo $class; ?>"><?php echo htmlspecialchars($status); ?></span>
          </td>
          <td><?php echo htmlspecialchars($row['date_submitted']); ?></td>
          <td><a href="update_status.php?id=<?php echo $row['id']; ?>" class="btn main-btn">Edit</a></td>
        </tr>
        <?php endwhile; ?>
      </table>
    </div>
  </div>
</body>
</html>
