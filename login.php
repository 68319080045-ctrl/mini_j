<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raven Tone Login | Bootstrap 5</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        
        body {
            background-color: #0d0d0d;
            
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        
        .login-card {
            background-color: #1a1a1a;
            
            color: #f8f9fa;
            
            border-radius: 1rem;
            
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            
            width: 100%;
            max-width: 400px;
            
            padding: 2rem;
            text-align: center;
        }

        
        .form-control {
            background-color: #2c2c2c;
            
            border: 1px solid #495057;
            
            color: #f8f9fa;
            
        }

        .form-control:focus {
            background-color: #2c2c2c;
            color: #f8f9fa;
            border-color: #5d5f66;
            
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
            
        }

        
        .btn-raven {
            background-color: #4a4a4a;
            
            border-color: #4a4a4a;
            color: #ffffff;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .btn-raven:hover {
            background-color: #5c5c5c;
            
            border-color: #5c5c5c;
            color: #ffffff;
        }

        
        .btn-primary-custom {
            background-color: #9c27b0;
            
            border-color: #9c27b0;
            color: #ffffff;
        }

        .btn-primary-custom:hover {
            background-color: #a84db9;
            border-color: #a84db9;
        }

        
        .form-floating>.form-control {
            height: calc(3.5rem + 2px);
            
        }

        .form-floating>label {
            color: #ced4da;
            
        }
    </style>
</head>

<body>

    <div class="login-card">
        <h2 class="text-center mb-4 fw-bold">เข้าสู่ระบบ</h2>
        <form action="check_login.php" method="post">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" name="username"
                    placeholder="name@example.com">
                <label for="floatingInput">อีเมล หรือ ชื่อผู้ใช้</label>
            </div>

            <div class="form-floating mb-4">
                <input type="password" class="form-control" id="floatingPassword" name="password"
                    placeholder="Password">
                <label for="floatingPassword">รหัสผ่าน</label>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="rememberMe">
                    <label class="form-check-label" for="rememberMe">
                        จำฉันไว้
                    </label>
                </div>
                <a href="#" class="text-secondary text-decoration-none" style="font-size: 0.9rem;">ลืมรหัสผ่าน?</a>
            </div>

            <button type="submit" class="btn btn-primary-custom w-100 py-2 mb-3">
                เข้าสู่ระบบ
            </button>

            <p class="text-center text-secondary mt-3" style="font-size: 0.9rem;">
                ยังไม่มีบัญชี? <a href="register.php" class="text-decoration-none fw-bold"
                    style="color: #9c27b0;">ลงทะเบียนที่นี่</a>
            </p>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>