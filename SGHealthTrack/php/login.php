<?php
session_start();

// Regenerate session ID to prevent session fixation
session_regenerate_id(true);

include 'db.php';

// Rate limiting (simple implementation)
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['last_attempt'] = time();
}

// Check if too many attempts
if ($_SESSION['login_attempts'] >= 5) {
    $time_since_last = time() - $_SESSION['last_attempt'];
    if ($time_since_last < 900) { // 15 minutes lockout
        $remaining = 900 - $time_since_last;
        echo "<script>
                alert('Too many failed attempts. Please try again in " . ceil($remaining/60) . " minutes.');
                window.location='../index.html';
              </script>";
        exit();
    } else {
        // Reset attempts after lockout period
        $_SESSION['login_attempts'] = 0;
    }
}

// Validate and sanitize input
if (!isset($_POST['username']) || !isset($_POST['password'])) {
    echo "<script>alert('Invalid request'); window.location='../index.html';</script>";
    exit();
}

$username = sanitize_input($_POST['username']);
$password = $_POST['password']; // Don't sanitize password as it may contain special chars

// Validate input length
if (strlen($username) < 3 || strlen($username) > 50) {
    echo "<script>alert('Invalid username'); window.location='../index.html';</script>";
    exit();
}

// Use prepared statement to prevent SQL injection
$stmt = $conn->prepare("SELECT id, username, password, fullname, role FROM users WHERE username = ? LIMIT 1");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
    
    // Verify password using password_verify for hashed passwords
    if (password_verify($password, $user['password'])) {
        // Reset login attempts on successful login
        $_SESSION['login_attempts'] = 0;
        
        // Store user info in session with proper validation
        $_SESSION['user_id'] = (int)$user['id'];
        $_SESSION['username'] = htmlspecialchars($user['username']);
        $_SESSION['fullname'] = htmlspecialchars($user['fullname'] ?? $user['username']);
        $_SESSION['role'] = htmlspecialchars($user['role'] ?? 'user');
        $_SESSION['login_time'] = time();
        
        // Set secure session cookie parameters
        $secure = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';
        $httponly = true;
        $samesite = 'Strict';
        
        session_set_cookie_params([
            'lifetime' => 0,
            'path' => '/',
            'domain' => '',
            'secure' => $secure,
            'httponly' => $httponly,
            'samesite' => $samesite
        ]);
        
        echo "<script>
                alert('Login successful!'); 
                window.location='dashboard.php';
              </script>";
    } else {
        // Increment failed attempts
        $_SESSION['login_attempts']++;
        $_SESSION['last_attempt'] = time();
        
        // Log failed attempt
        error_log("Failed login attempt for username: $username from IP: " . $_SERVER['REMOTE_ADDR']);
        
        echo "<script>
                alert('Invalid credentials'); 
                window.location='../index.html';
              </script>";
    }
} else {
    // Increment failed attempts even for non-existent users
    $_SESSION['login_attempts']++;
    $_SESSION['last_attempt'] = time();
    
    echo "<script>
            alert('Invalid credentials'); 
            window.location='../index.html';
          </script>";
}

$stmt->close();
$conn->close();
?>