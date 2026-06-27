<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'RPLShop') ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; background: #0f172a; color: #f8fafc; }
        main { max-width: 900px; margin: 0 auto; padding: 48px 20px; }
        .card { background: #111827; padding: 24px; border-radius: 16px; box-shadow: 0 12px 32px rgba(0,0,0,.25); }
        a { color: #fbbf24; }
    </style>
</head>
<body>
    <main>
        <section class="card">
            <h1><?= htmlspecialchars($siteName ?? 'RPLShop') ?></h1>
            <p><?= htmlspecialchars($description ?? 'Aplikasi ini sekarang disiapkan dengan struktur yang lebih cocok untuk Vercel.') ?></p>
            <p>Halaman ini adalah entry point PHP yang dipisahkan dari template HTML agar lebih mudah di-deploy.</p>
            <p>Untuk fitur lengkap seperti database, checkout, dan admin, masih diperlukan migrasi lanjutan ke arsitektur serverless atau hosting PHP biasa.</p>
        </section>
    </main>
</body>
</html>
