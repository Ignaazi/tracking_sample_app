<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Amcor System Scanner</title>
    <!-- Bootstrap 5 & FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --amcor-white: #ffffff;
            --amcor-light-green: #7ED348;
            --amcor-green: #26B170;
            --amcor-dark-blue: #01377D;
            --amcor-sky-blue: #009DD1;
            --amcor-dark: #1E293B;
        }
        
        body { 
            font-family: "Nunito", sans-serif; 
            position: relative;
            height: 100vh; 
            display: flex; 
            align-items: center; 
            justify-content: center;
            margin: 0;
            padding: 20px;
            overflow: hidden;
            background-color: #eef2f5;
        }

        body::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background-image: url("{{ asset('bg-login.png') }}");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            filter: brightness(0.95); 
            z-index: -1;
        }

        .login-wrapper {
            position: relative;
            width: 100%;
            max-width: 980px;
            z-index: 2;
        }

        .login-card {
            width: 100%;
            background-color: #ffffff;
            border-radius: 40px;
            border-top: 2.5px solid var(--amcor-green);
            border-bottom: 2.5px solid var(--amcor-light-green);
            border-left: 1px solid rgba(255, 255, 255, 0.5);
            border-right: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 
                0px 25px 70px rgba(1, 41, 112, 0.12),
                inset 0 1px 0 rgba(255, 255, 255, 0.6),
                inset 0 -1px 0 rgba(0, 0, 0, 0.05);
            overflow: hidden;
            display: flex;
            min-height: 550px;
            position: relative;
        }

        .login-left-side {
            flex: 1.1;
            padding: 50px 70px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background-color: #ffffff;
            z-index: 3;
        }

        .login-right-side {
            flex: 0.9;
            background-color: #ffffff;
            background-image: 
                radial-gradient(at 85% 15%, rgba(126, 211, 72, 0.18) 0px, transparent 55%),
                radial-gradient(at 95% 85%, rgba(1, 55, 125, 0.16) 0px, transparent 60%),
                radial-gradient(at 35% 95%, rgba(0, 157, 209, 0.14) 0px, transparent 50%),
                radial-gradient(at 90% 50%, rgba(38, 177, 112, 0.1) 0px, transparent 45%);
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            z-index: 1;
            border-left: 1px solid #f3f4f6; 
        }

        .welcome-text {
            font-size: 30px;
            color: #2d3748;
            margin-bottom: 15px;
            line-height: 1.25;
            font-weight: 400;
        }
        .welcome-text .highlight { color: var(--amcor-green); font-weight: 700; }

        .form-label-custom {
            font-size: 11px;
            font-weight: 800;
            color: #4a5568;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 6px;
            display: block;
        }

        .input-wrapper { position: relative; margin-bottom: 6px; }
        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #a0aec0;
            font-size: 14px;
        }
        .input-field {
            width: 100%;
            padding: 12px 16px 12px 45px;
            font-size: 13.5px;
            background-color: #f8fafc;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            color: var(--amcor-dark);
            transition: all 0.25s ease-in-out;
        }
        .input-field::placeholder { color: #cbd5e0; }
        .input-field:focus {
            outline: none;
            background-color: #ffffff;
            border-color: var(--amcor-dark-blue);
            box-shadow: 0 0 0 3px rgba(1, 55, 125, 0.1);
        }

        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #a0aec0;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-login-gradient {
            background: linear-gradient(90deg, var(--amcor-light-green) 0%, var(--amcor-green) 100%);
            border: none;
            color: #ffffff;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.5px;
            padding: 13px;
            border-radius: 25px;
            width: 100%;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0px 8px 20px rgba(38, 177, 112, 0.15);
            margin-top: 15px;
        }
        .btn-login-gradient:hover {
            transform: translateY(-1.5px);
            box-shadow: 0px 12px 25px rgba(38, 177, 112, 0.25);
            opacity: 0.95;
        }

        .back-link {
            font-size: 12px;
            color: #718096;
            text-decoration: none;
            font-weight: 700;
            transition: color 0.2s ease;
            display: inline-block;
            margin-top: 15px;
        }
        .back-link:hover {
            color: var(--amcor-dark-blue);
        }

        .visual-logo {
            max-width: 65%;
            max-height: 65%;
            object-fit: contain;
            filter: drop-shadow(0px 10px 20px rgba(0, 0, 0, 0.06));
            z-index: 3;
        }

        .login-footer {
            margin-top: 25px;
            font-size: 11px;
            color: #a0aec0;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="login-wrapper">
        <div class="login-card">
            
            <div class="login-left-side">
                <h2 class="welcome-text">
                    Create New<br>
                    <span class="highlight">Password</span>
                </h2>
                <p class="text-muted mb-4" style="font-size: 13px; line-height: 1.5;">
                    Silakan buat password baru Anda (minimal 8 karakter).
                </p>

                <!-- Alert Error Laravel -->
                @if($errors->any())
                    <div class="alert alert-danger border-0 p-2 small mb-3 d-flex align-items-center gap-2" style="background-color: #fde1e1; color: #842029; border-radius: 8px;">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <form action="{{ route('password.update') }}" method="POST">
                    @csrf
                    
                    <!-- Input Password Baru -->
                    <div class="mb-3">
                        <label class="form-label-custom">New Password</label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-lock input-icon"></i>
                            <input type="password" name="password" id="passwordInput" class="input-field" required placeholder="Masukkan password baru">
                            <i class="fa-regular fa-eye-slash password-toggle" id="togglePassword"></i>
                        </div>
                    </div>
                    
                    <!-- Input Konfirmasi Password -->
                    <div class="mb-2">
                        <label class="form-label-custom">Confirm New Password</label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-lock input-icon"></i>
                            <input type="password" name="password_confirmation" id="passwordConfirmInput" class="input-field" required placeholder="Ulangi password baru">
                            <i class="fa-regular fa-eye-slash password-toggle" id="togglePasswordConfirm"></i>
                        </div>
                    </div>
                    
                    <button type="submit" id="btnSubmit" class="btn-login-gradient text-uppercase">
                        SIMPAN PASSWORD BARU
                    </button>
                </form>

                <div class="text-center">
                    <a href="{{ route('login') }}" class="back-link">
                        <i class="fa-solid fa-arrow-left me-1"></i> Batal & Kembali ke Login
                    </a>
                </div>

                <div class="login-footer">
                    Tracking Sample System &bull; &copy; {{ date('Y') }} Amcor Flexibles
                </div>

            </div>

            <div class="login-right-side">
                <img src="{{ asset('logo1.png') }}" alt="Amcor Brand Icon" class="visual-logo">
            </div>

        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Toggle Password Baru
        const togglePassword = document.querySelector('#togglePassword');
        const passwordInput = document.querySelector('#passwordInput');

        togglePassword.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });

        // Toggle Konfirmasi Password
        const togglePasswordConfirm = document.querySelector('#togglePasswordConfirm');
        const passwordConfirmInput = document.querySelector('#passwordConfirmInput');

        togglePasswordConfirm.addEventListener('click', function () {
            const type = passwordConfirmInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordConfirmInput.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });

        // Prevent Space pada kedua input password
        [passwordInput, passwordConfirmInput].forEach(input => {
            input.addEventListener('keydown', function (e) {
                if (e.key === ' ' || e.keyCode === 32) {
                    e.preventDefault();
                }
            });
            input.addEventListener('input', function () {
                this.value = this.value.replace(/\s/g, '');
            });
        });
    </script>

</body>
</html>