<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SYS.AUTH // Operator Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #07090e;
            color: #00e5ff;
            font-family: 'JetBrains Mono', monospace;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            background-image: radial-gradient(circle at 50% 50%, rgba(0, 229, 255, 0.05) 0%, transparent 60%);
        }
        .login-box {
            background: #0e121a;
            border: 1px solid rgba(0, 229, 255, 0.3);
            border-radius: 6px;
            padding: 36px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 0 30px rgba(0, 229, 255, 0.15);
            box-sizing: border-box;
        }
        .login-header {
            text-align: center;
            margin-bottom: 28px;
        }
        .login-header h1 {
            font-size: 1.3rem;
            margin: 0 0 8px 0;
            letter-spacing: 2px;
            color: #00e5ff;
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
            background: #07090e;
            border: 1px solid rgba(0, 229, 255, 0.25);
            color: #fff;
            font-family: inherit;
            font-size: 0.9rem;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input:focus {
            outline: none;
            border-color: #00e5ff;
            box-shadow: 0 0 10px rgba(0, 229, 255, 0.25);
        }
        .btn-submit {
            width: 100%;
            padding: 12px;
            background: #00e5ff;
            border: none;
            color: #07090e;
            font-family: inherit;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            cursor: pointer;
            border-radius: 4px;
            margin-top: 10px;
            transition: all 0.2s;
        }
        .btn-submit:hover {
            box-shadow: 0 0 20px rgba(0, 229, 255, 0.5);
            transform: translateY(-1px);
        }
        .alert {
            background: rgba(255, 51, 102, 0.1);
            border: 1px solid #ff3366;
            color: #ff6b8b;
            padding: 10px 14px;
            font-size: 0.8rem;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .alert-info {
            background: rgba(0, 229, 255, 0.1);
            border: 1px solid #00e5ff;
            color: #00e5ff;
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
            color: #00e5ff;
        }
    </style>
</head>
<body>
    <div class="login-box">
        <div class="login-header">
            <h1>SYS.AUTH // OPERATOR</h1>
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
                <label for="username">// OPERATOR IDENTIFIER</label>
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
