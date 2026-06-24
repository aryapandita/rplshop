<?php
// auth/register-process.php

require_once __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $full_name = trim($_POST['full_name']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validations
    if (empty($username) || empty($email) || empty($full_name) || empty($password) || empty($confirm_password)) {
        $_SESSION['register_error'] = 'Semua field wajib diisi.';
        header("Location: ../pages/register.php");
        exit;
    }
    
    if (strlen($password) < 6) {
        $_SESSION['register_error'] = 'Password minimal terdiri dari 6 karakter.';
        header("Location: ../pages/register.php");
        exit;
    }
    
    if ($password !== $confirm_password) {
        $_SESSION['register_error'] = 'Konfirmasi password tidak cocok.';
        header("Location: ../pages/register.php");
        exit;
    }
    
    // Check if username already exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$username]);
    if ($stmt->fetch()) {
        $_SESSION['register_error'] = 'Username sudah terdaftar. Silakan pilih username lain.';
        header("Location: ../pages/register.php");
        exit;
    }
    
    // Check if email already exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        $_SESSION['register_error'] = 'Alamat email sudah terdaftar. Silakan gunakan email lain.';
        header("Location: ../pages/register.php");
        exit;
    }
    
    // Hash password and insert
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password, full_name, role) VALUES (?, ?, ?, ?, 'user')");
    
    if ($stmt->execute([$username, $email, $hashed_password, $full_name])) {
        // Get inserted ID
        $new_user_id = $pdo->lastInsertId();
        
        // Log user in automatically
        $_SESSION['user_id'] = $new_user_id;
        $_SESSION['user_username'] = $username;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_fullname'] = $full_name;
        $_SESSION['user_role'] = 'user';
        
        header("Location: ../index.php");
        exit;
    } else {
        $_SESSION['register_error'] = 'Terjadi kesalahan sistem. Silakan coba lagi.';
        header("Location: ../pages/register.php");
        exit;
    }
} else {
    header("Location: ../pages/register.php");
    exit;
}
