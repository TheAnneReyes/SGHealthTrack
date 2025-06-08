SG HealthTrack - Clinic Management System
A comprehensive web-based clinic management system designed to streamline healthcare operations, patient management, and administrative tasks.
Features
🏥 Dashboard Overview

Real-time patient metrics and statistics
Today's appointments and patient queue
Revenue tracking and analytics
Interactive patient volume charts

👥 Patient Management

Patient records management
Appointment scheduling
Queue management system
Payment processing and tracking

📊 Analytics & Reporting

Patient volume analytics with Chart.js
Revenue reporting
Appointment status tracking
Real-time dashboard metrics

Tech Stack

Frontend: HTML5, CSS3, JavaScript
Backend: PHP
Database: MySQL 
Charts: Chart.js
Icons: Font Awesome 6.5.0

File Structure
sg-healthtrack/
├── index.html              # Login page
├── style.css              # Login page styles
├── php/
│   ├── dashboard.php      # Main dashboard
│   ├── login.php          # Login authentication
│   ├── logout.php         # Session management
│   └── db.php             # Database connection
└── css/
    └── dashboard.css      # Dashboard styles
Installation
Prerequisites

Web server (Apache/Nginx)
PHP 7.4 or higher
MySQL 5.7 or higher

Setup Instructions

Clone or download the project files
bashgit clone [repository-url]
cd sg-healthtrack

Database Setup

Create a MySQL database
Create a users table:

sqlCREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
);

INSERT INTO users (username, password) VALUES ('admin', 'password123');

Configure Database Connection

Update php/db.php with your database credentials:

php<?php
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database";

$conn = new mysqli($servername, $username, $password, $dbname);
?>

Deploy to Web Server

Upload files to your web server's document root
Ensure PHP has proper permissions



Usage
Login

Access the application through your web browser
Use the demo credentials:

Username: admin
Password: password123



Dashboard Features

Metrics Cards: View today's patients, appointments, revenue, and queue status
Quick Actions: Access shortcuts for common tasks
Patient Queue: Monitor current patient status
Appointments Table: View scheduled appointments with status
Payment Tracking: Monitor payment status for services
Analytics Chart: Visual representation of patient volume trends

Demo Data
The system includes sample data for demonstration:

3 patients in queue (Sarah Wilson, Michael Chen, Emma Johnson)
Various appointment types (Consultation, Follow-up, Check-up)
Payment statuses (Paid, Pending, Overdue)
6 months of patient volume data

Security Notes
⚠️ Important: This is a demo application and contains security vulnerabilities that should be addressed before production use:

SQL Injection: Login queries are not using prepared statements
Password Security: Passwords are stored in plain text
Session Security: Basic session management implementation
Input Validation: Limited input sanitization

Recommended Security Improvements

Implement prepared statements for database queries
Hash passwords using password_hash() and verify with password_verify()
Add CSRF protection
Implement input validation and sanitization
Use HTTPS in production
Add rate limiting for login attempts

Browser Compatibility

Chrome 80+
Firefox 75+
Safari 13+
Edge 80+

Contributing

Fork the repository
Create a feature branch
Make your changes
Test thoroughly
Submit a pull request

License
This project is for educational/demonstration purposes. Please ensure proper licensing for production use.
Support
For issues or questions:

Check the code comments for implementation details
Ensure database connection is properly configured
Verify file permissions on your web server

Changelog
v1.0.0

Initial release
Basic login/logout functionality
Dashboard with patient metrics
Appointment and payment tracking
Patient volume analytics


Note: This is a demonstration application. For production use, please implement proper security measures, error handling, and database optimization.