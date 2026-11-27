<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SYS.AUTH // Operator Login &bull; x64emkei</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700;800&family=Outfit:wght@400;600;700&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('style.css') ?>">
    <style>
        body {
            background-color: #06080A;
            color: #f8fafc;
            font-family: 'JetBrains Mono', monospace;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            background-image: 
                linear-gradient(rgba(255, 42, 42, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 42, 42, 0.03) 1px, transparent 1px);
            background-size: 32px 32px;
        }
        .login-box {
            background: var(--glass-bg);
            backdrop-filter: var(--glass-blur);
            -webkit-backdrop-filter: var(--glass-blur);
            border: 1px solid var(--glass-border);
            border-top: 2px solid var(--primary);
            border-radius: var(--card-radius-lg);
            padding: 36px;
            width: 100%;
            max-width: 420px;
            box-shadow: var(--glass-shadow);
            box-sizing: border-box;
            position: relative;
        }
        .login-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, #FF2A2A, transparent);
        }
        .login-header {
            text-align: center;
            margin-bottom: 28px;
        }
        .login-header h1 {
            font-size: 1.3rem;
            margin: 0 0 8px 0;
            letter-spacing: 2px;
            color: var(--primary);
            font-family: 'Space Grotesk', sans-serif;
        }
        .login-header p {
            color: #64748b;
            font-size: 0.8rem;
            margin: 0;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            font-size: 0.78rem;
            color: #94a3b8;
            margin-bottom: 6px;
            letter-spacing: 0.5px;
        }
        input {
            width: 100%;
            padding: 12px 14px;
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            color: #fff;
            font-family: inherit;
            font-size: 0.9rem;
            border-radius: var(--card-radius-sm);
            box-sizing: border-box;
            transition: border-color 0.2s;
        }
        input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 2px 2px 0px #000000;
        }
        .btn-submit {
            width: 100%;
            padding: 12px;
            background: var(--primary);
            border: 1px solid var(--primary);
            color: #ffffff;
            font-family: inherit;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            cursor: pointer;
            border-radius: 4px;
            margin-top: 10px;
            box-shadow: 3px 3px 0px #000000;
            transition: all 0.2s;
        }
        .btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: 4px 4px 0px #000000;
            background: #ff4545;
        }
        .alert {
            background: rgba(255, 42, 42, 0.1);
            border: 1px solid var(--primary);
            color: #ff6b8b;
            padding: 10px 14px;
            font-size: 0.8rem;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .alert-info {
            background: rgba(255, 42, 42, 0.08);
            border: 1px solid var(--primary);
            color: #f8fafc;
        }
        .back-link {
            text-align: center;
            margin-top: 24px;
            font-size: 0.8rem;
        }
        .back-link a {
            color: #64748b;
            text-decoration: none;
        }
        .back-link a:hover {
            color: var(--primary);
        }
    </style>
</head>
<body>
    <div class="login-box">
        <div class="login-header">
            <h1>ADMIN LOGIN</h1>
            <p>X64EMKEI Telemetry Control Deck</p>
        </div>

        <?php if (has_flash('error')): ?>
            <div class="alert"><?= e(flash('error')) ?></div>
        <?php endif; ?>

        <?php if (has_flash('info')): ?>
            <div class="alert alert-info"><?= e(flash('info')) ?></div>
        <?php endif; ?>

        <form action="<?= e(url('admin/login')) ?>" method="POST">
            <?= csrf_field() ?>
            <div class="form-group">
                <label for="username">// USERNAME</label>
                <input type="text" id="username" name="username" required autocomplete="username" autofocus>
            </div>
            <div class="form-group">
                <label for="password">// SECURITY CIPHER</label>
                <input type="password" id="password" name="password" required autocomplete="current-password">
            </div>
            <button type="submit" class="btn-submit">AUTHENTICATE &rarr;</button>
        </form>

        <div class="back-link">
            <a href="<?= e(url('/')) ?>">&larr; Return to Public Telemetry</a>
        </div>
    </div>
</body>
</html>
