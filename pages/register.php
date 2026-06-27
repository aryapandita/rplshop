<?php
// pages/register.php
$path_prefix = '../';
$page_title = 'Sign Up - RPLShop';
$extra_css = ['auth-7f3c9e2a1b.css'];

require_once __DIR__ . '/../includes/functions.php';

// Redirect if already logged in
if (is_logged_in()) {
    header("Location: ../index.php");
    exit;
}

$error = '';
$success = '';

if (isset($_SESSION['register_error'])) {
    $error = $_SESSION['register_error'];
    unset($_SESSION['register_error']);
}

if (isset($_SESSION['register_success'])) {
    $success = $_SESSION['register_success'];
    unset($_SESSION['register_success']);
}

include __DIR__ . '/../includes/header.php';
?>

<div class="auth-page">
    <div class="auth-card auth-card--wide">
        
        <div class="auth-header">
            <h2>Daftar Akun Baru</h2>
            <p>Bergabung dengan RPLShop untuk memulai petualangan gaming Anda.</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="auth-alert auth-alert-error">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class="auth-alert auth-alert-success">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <form method="post" action="../auth/register-process.php" class="auth-form auth-form--spaced">
            <div class="auth-field auth-field--compact">
                <label for="username" class="auth-field-label">Username</label>
                <input type="text" id="username" name="username" required placeholder="Pilih username unik" class="auth-input">
            </div>

            <div class="auth-field auth-field--compact">
                <label for="email" class="auth-field-label">Alamat Email</label>
                <input type="email" id="email" name="email" required placeholder="Masukkan email aktif Anda" class="auth-input">
            </div>

            <div class="auth-field auth-field--compact">
                <label for="full_name" class="auth-field-label">Nama Lengkap</label>
                <input type="text" id="full_name" name="full_name" required placeholder="Masukkan nama lengkap Anda" class="auth-input">
            </div>

            <div class="auth-field auth-field--compact">
                <label for="password" class="auth-field-label">Password</label>
                <input type="password" id="password" name="password" required placeholder="Minimal 6 karakter" class="auth-input">
            </div>

            <div class="auth-field">
                <label for="confirm_password" class="auth-field-label">Konfirmasi Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required placeholder="Ulangi password Anda" class="auth-input">
            </div>

            <button type="submit" class="auth-button auth-button-success">
                <span>DAFTAR SEKARANG</span>
            </button>
        </form>

        <div class="auth-footer">
            Sudah punya akun? <a href="login.php">Masuk</a>
        </div>

    </div>
</div>

<?php
include __DIR__ . '/../includes/footer.php';
?>
