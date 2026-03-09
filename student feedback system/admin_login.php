<?php
session_start();
include 'db_connect.php';
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT id, username, password FROM admin WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if ($password === $row['password']) {
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['admin_username'] = $row['username'];
            header("Location: admin_dashboard.php");
            exit();
        } else {
            $message = "Invalid password.";
        }
    } else {
        $message = "Admin user not found.";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Login</title>
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

    <div class="nav-buttons">
      <a href="index.html" class="btn secondary-btn">Home</a>
      <a href="report_issue.html" class="btn nav-btn">Report Issue</a>
    </div>
  </header>

  <section class="form-section">
    <div class="form-container">
      <div class="form-left">
        <span class="tagline">Admin Portal</span>
        <h1>Admin Login</h1>
        <p>Login to manage student issues, update issue status, and monitor the system dashboard.</p>
        <div class="info-list">
          <div class="info-item">📊 View dashboard summary</div>
          <div class="info-item">📋 Check all submitted issues</div>
          <div class="info-item">✅ Update issue status easily</div>
        </div>
      </div>

      <div class="form-card">
        <div class="form-header">
          <h2>Login Form</h2>
          <p>Enter admin username and password.</p>
        </div>

        <?php if ($message != ""): ?>
          <div class="error"><?php echo $message; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
          <label for="username">Username</label>
          <input type="text" id="username" name="username" required>

          <label for="password">Password</label>
          <input type="password" id="password" name="password" required>

          <div class="hero-buttons">
            <button type="submit" class="btn main-btn">Login</button>
            <a href="index.html" class="btn secondary-btn">Back to Home</a>
          </div>
        </form>

        <p class="small">Default login: admin / admin123</p>
      </div>
    </div>
  </section>
</body>
</html>
