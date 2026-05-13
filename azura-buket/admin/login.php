<?php session_start(); ?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin — Azura Buket</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to right, #c0395e, #e8729a);
        }
        .login-box {
            margin-top: 100px;
            border-radius: 15px;
        }
        .login-logo {
            text-align: center;
            margin-bottom: 20px;
        }
        .login-logo h2 {
            font-family: Georgia, serif;
            font-weight: 700;
            color: #c0395e;
        }
        .login-logo small {
            color: #9b6b7e;
            font-size: .85rem;
        }
        .btn-brand {
            background: linear-gradient(135deg, #c0395e, #e8729a);
            color: #fff;
            border: none;
        }
        .btn-brand:hover {
            background: linear-gradient(135deg, #8e1f3d, #c0395e);
            color: #fff;
        }
    </style>
</head>

<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card login-box shadow">
                <div class="card-body">

                    <div class="login-logo">
                        <h2>🌸 Azura Buket</h2>
                        <small>Admin Panel</small>
                    </div>

                    <?php if(isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger">
                            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                        </div>
                    <?php endif; ?>

                    <form action="proses_login.php" method="POST">

                        <div class="mb-3">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="mb-3 text-center">
                            <img src="captcha.php" alt="captcha" style="border-radius:8px;border:1px solid #f5c0cc;">
                        </div>

                        <div class="mb-3">
                            <label>Masukkan CAPTCHA</label>
                            <input type="text" name="captcha" class="form-control" required>
                        </div>

                        <button type="submit" name="login" class="btn btn-brand w-100">
                            🌸 Login Admin
                        </button>

                    </form>

                    <div class="text-center mt-3">
                        <small class="text-muted">Default: admin / azura2025</small>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
