CREATE DATABASE IF NOT EXISTS student_feedback_system;
USE student_feedback_system;

CREATE TABLE IF NOT EXISTS issues (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_name VARCHAR(100) NOT NULL,
    student_id VARCHAR(50) NOT NULL,
    student_email VARCHAR(100) NOT NULL,
    category VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    status VARCHAR(50) NOT NULL DEFAULT 'Pending',
    date_submitted TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

INSERT INTO admin (username, password)
VALUES ('admin', 'admin123')
ON DUPLICATE KEY UPDATE username = username;

INSERT INTO issues (student_name, student_id, student_email, category, description, status) VALUES
('Kamal Perera', 'ST001', 'kamal@example.com', 'WiFi Issue', 'WiFi connection is not working in the library.', 'Pending'),
('Nimali Silva', 'ST002', 'nimali@example.com', 'Transport Issue', 'Bus service is late in the morning.', 'In Progress'),
('Sahan Fernando', 'ST003', 'sahan@example.com', 'Lab Issue', 'Computer number 12 is not working in the lab.', 'Solved');
