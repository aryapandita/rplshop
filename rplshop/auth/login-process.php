<?php
// auth/login-process.php

require_once __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username_or_email = trim($_POST['username']);
    $password = $_POST['password'];
    
    if (empty($username_or_email) || empty($password)) {
        $_SESSION['login_error'] = 'Semua field wajib diisi.';
        header("Location: ../pages/login.php");
        exit;
    }
    
    // Check in DB by username or email
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username_or_email, $username_or_email]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['password'])) {
        // Set sessions
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_username'] = $user['username'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_fullname'] = $user['full_name'];
        $_SESSION['user_role'] = $user['role'];
        
        // Redirect to homepage
        header("Location: ../index.php");
        exit;
    } else {
        $_SESSION['login_error'] = 'Username, email, atau password salah.';
        header("Location: ../pages/login.php");
        exit;
    }
} else {
    header("Location: ../pages/login.php");
    exit;
}
