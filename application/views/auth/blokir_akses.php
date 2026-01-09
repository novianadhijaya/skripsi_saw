<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Akses Diblokir</title>
    <style>
        body {
            margin: 0;
            font-family: "Segoe UI", Arial, sans-serif;
            background: linear-gradient(135deg, #f5f7fa, #e8ecf3);
            color: #243447;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            max-width: 520px;
            width: 90%;
            padding: 26px 28px;
            text-align: center;
            border: 1px solid #e5e9f0;
        }
        .icon {
            width: 64px;
            height: 64px;
            margin: 0 auto 12px;
            border-radius: 50%;
            background: #ffe6e6;
            color: #e74c3c;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            box-shadow: inset 0 0 0 2px rgba(231,76,60,0.2);
        }
        h1 {
            margin: 8px 0 6px 0;
            font-size: 22px;
            font-weight: 800;
            letter-spacing: 0.2px;
        }
        p {
            margin: 6px 0;
            font-size: 14px;
            color: #5a6a7a;
            line-height: 1.5;
        }
        .btn {
            display: inline-block;
            margin-top: 14px;
            padding: 10px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 700;
            letter-spacing: 0.2px;
            color: #fff;
            background: #3498db;
            box-shadow: 0 6px 16px rgba(52,152,219,0.35);
        }
        .btn:hover { background: #2d89c6; }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon">!</div>
        <h1>Akses Diblokir</h1>
        <p>Anda tidak memiliki hak akses untuk halaman ini.</p>
        <p>Silakan hubungi administrator jika merasa perlu.</p>
        <a class="btn" href="<?php echo site_url('welcome'); ?>">Kembali ke Beranda</a>
    </div>
</body>
</html>
