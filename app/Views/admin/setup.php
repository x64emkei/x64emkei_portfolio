<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SYS.INIT // Primary Administrator Setup</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #07090e;
            color: #f8fafc;
            font-family: 'JetBrains Mono', monospace;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            background-image: radial-gradient(circle at 50% 50%, rgba(16, 185, 129, 0.05) 0%, transparent 60%);
        }
        .setup-box {
            background: #0e121a;
            border: 1px solid rgba(16, 185, 129, 0.4);
            border-radius: 6px;
            padding: 36px;
            width: 100%;
            max-width: 480px;
            box-shadow: 0 0 30px rgba(16, 185, 129, 0.15);
            box-sizing: border-box;
        }
        .setup-header {
            text-align: center;
            margin-bottom: 28px;
        }
        .setup-header h1 {
            font-size: 1.3rem;
            margin: 0 0 8px 0;
            letter-spacing: 2px;
            color: #10b981;
        }
        .setup-header p {
            color: #94a3b8;
            font-size: 0.82rem;
            margin: 0;
        }
        .form-group {
            margin-bottom: 18px;
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
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: #fff;
            font-family: inherit;
            font-size: 0.9rem;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input:focus {
            outline: none;
            border-color: #10b981;
            box-shadow: 0 0 10px rgba(16, 185, 129, 0.25);
        }
        .btn-submit {
            width: 100%;
            padding: 13px;
            background: #10b981;
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
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.5);
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
    </style>
</head>
<body>
    <div class="setup-box">
        <div class="setup-header">
            <h1>SYS.INITIALIZE // OPERATOR #1</h1>
            <p>Configure the initial primary administrator account for this installation. No default credentials are pre-packaged.</p>
        </div>

        <?php if (has_flash('error')): ?>
            <div class="alert"><?= e(flash('error')) ?></div>
        <?php endif; ?>

        <form action="<?= e(url('admin/setup')) ?>" method="POST">
            <?= csrf_field() ?>
            <div class="form-group">
                <label for="username">// OPERATOR USERNAME</label>
                <input type="text" id="username" name="username" value="<?= old('username', 'x64emkei') ?>" required autofocus>
            </div>
            <div class="form-group">
                <label for="email">// NOTIFICATION EMAIL</label>
                <input type="email" id="email" name="email" value="<?= old('email', 'mordenes@acm.org') ?>" required>
            </div>
            <div class="form-group">
                <label for="password">// MASTER PASSCODE (MINIMUM 8 CHARACTERS)</label>
                <input type="password" id="password" name="password" minlength="8" required>
            </div>
            <div class="form-group">
                <label for="password_confirmation">// CONFIRM MASTER PASSCODE</label>
                <input type="password" id="password_confirmation" name="password_confirmation" minlength="8" required>
            </div>
            <button type="submit" class="btn-submit">INITIALIZE ADMINISTRATOR &rarr;</button>
        </form>
    </div>
</body>
</html>
