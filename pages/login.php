<?php
// pages/login.php
$path_prefix = '../';
$page_title = 'Sign In - RPLShop';
$extra_css = ['auth-7f3c9e2a1b.css'];

require_once __DIR__ . '/../includes/functions.php';

// Redirect if already logged in
if (is_logged_in()) {
    header("Location: ../index.php");
    exit;
}

$error = '';
if (isset($_SESSION['login_error'])) {
    $error = $_SESSION['login_error'];
    unset($_SESSION['login_error']);
}

include __DIR__ . '/../includes/header.php';
?>

<div class="auth-page">
    <div class="auth-card">
        
        <div class="auth-header">
            <h2>Selamat Datang Kembali</h2>
            <p>Masuk ke akun RPLShop Anda untuk melanjutkan belanja.</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="auth-alert auth-alert-error">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="post" action="../auth/login-process.php" class="auth-form">
            <div class="auth-field">
                <label for="username" class="auth-field-label">Username atau Email</label>
                <input type="text" id="username" name="username" required placeholder="Masukkan username atau email Anda" class="auth-input">
            </div>

            <div class="auth-field">
                <label for="password" class="auth-field-label">Password</label>
                <input type="password" id="password" name="password" required placeholder="Masukkan password Anda" class="auth-input">
            </div>

            <button type="submit" class="auth-button auth-button-primary">
                <span>MASUK</span>
            </button>
        </form>

        <div class="auth-footer">
            Belum punya akun? <a href="register.php">Daftar Sekarang</a>
        </div>

    </div>
</div>

<?php
include __DIR__ . '/../includes/footer.php';
?>