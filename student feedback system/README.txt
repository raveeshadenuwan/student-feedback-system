Student Feedback and Issue Reporting System
Updated Version - Email + Logo

How to run
1. Install XAMPP and VS Code
2. Start Apache and MySQL in XAMPP
3. Copy this folder into:
   C:\xampp\htdocs\student_feedback_system
4. Open phpMyAdmin:
   http://localhost/phpmyadmin
5. Import:
   student_feedback_system.sql
6. Open in browser:
   http://localhost/student_feedback_system/index.html

Default admin login
Username: admin
Password: admin123

Important about email
- This project uses PHP mail() for automatic email when status becomes Solved.
- On XAMPP localhost, email may not send unless SMTP/mail is configured.
- Update config_email.php before testing.
- For real projects, PHPMailer is more reliable.
