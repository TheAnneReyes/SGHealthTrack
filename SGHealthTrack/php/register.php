<?php
session_start();
include 'db.php';

// CSRF protection - add this token to your signup form
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // CSRF validation (uncomment when you add the token to your form)
    /*
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        echo "<script>alert('Invalid request'); window.location='../signup.html';</script>";
        exit();
    }
    */
    
    // Get and sanitize form data
    $fullname = sanitize_input($_POST['fullname'] ?? '');
    $email = sanitize_input($_POST['email'] ?? '');
    $username = sanitize_input($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $role = sanitize_input($_POST['role'] ?? 'user');
    
    // Comprehensive validation
    $errors = [];
    
    // Validate required fields
    if (empty($fullname)) $errors[] = "Full name is required";
    if (empty($email)) $errors[] = "Email is required";
    if (empty($username)) $errors[] = "Username is required";
    if (empty($password)) $errors[] = "Password is required";
    
    // Validate fullname (2-50 characters, letters and spaces only)
    if (!empty($fullname) && !preg_match('/^[a-zA-Z\s]{2,50}$/', $fullname)) {
        $errors[] = "Full name must be 2-50 characters and contain only letters and spaces";
    }
    
    // Validate email
    if (!empty($email) && !validate_email($email)) {
        $errors[] = "Please enter a valid email address";
    }
    
    // Validate username (3-20 characters, alphanumeric and underscore only)
    if (!empty($username) && !preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username)) {
        $errors[] = "Username must be 3-20 characters and contain only letters, numbers, and underscores";
    }
    
    // Check if passwords match
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match";
    }
    
    // Validate password strength
    if (!empty($password) && !validate_password($password)) {
        $errors[] = "Password must be at least 8 characters with uppercase, lowercase, and number";
    }
    
    // Validate role
    $allowed_roles = ['admin', 'doctor', 'nurse', 'receptionist', 'user'];
    if (!in_array($role, $allowed_roles)) {
        $role = 'user'; // Default to user if invalid role
    }
    
    // Check if username already exists using prepared statement
    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $errors[] = "Username already exists";
        }
        $stmt->close();
    }
    
    // Check if email already exists using prepared statement
    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $errors[] = "Email already registered";
        }
        $stmt->close();
    }
    
    // If no errors, insert user
    if (empty($errors)) {
        // Hash the password with strong hashing
        $hashed_password = password_hash($password, PASSWORD_DEFAULT, [
            'memory_cost' => 65536, // 64 MB
            'time_cost' => 4,       // 4 iterations
            'threads' => 3,         // 3 threads
        ]);
        
        // Use prepared statement for insertion
        $stmt = $conn->prepare("INSERT INTO users (fullname, email, username, password, role, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("sssss", $fullname, $email, $username, $hashed_password, $role);
        
        if ($stmt->execute()) {
            // Log successful registration
            error_log("New user registered: $username ($email)");
            
            echo "<script>
                    alert('Account created successfully! You can now log in.');
                    window.location='../index.html';
                  </script>";
        } else {
            error_log("Registration error for $username: " . $stmt->error);
            echo "<script>
                    alert('Error creating account. Please try again.');
                    window.location='../signup.html';
                  </script>";
        }
        $stmt->close();
    } else {
        // Display errors
        $error_message = implode("\\n", $errors);
        echo "<script>
                alert('Registration failed:\\n$error_message');
                window.location='../signup.html';
              </script>";
    }
} else {
    // If accessed directly, redirect to signup page
    header("Location: ../signup.html");
    exit();
}

$conn->close();
?>