<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Amcor System Scanner</title>
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

        /* Background menggunakan gambar dari public/bg-login.png */
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

        /* Container Pembungkus */
        .login-wrapper {
            position: relative;
            width: 100%;
            max-width: 980px;
            z-index: 2;
        }

        /* Card Utama */
        .login-card {
            width: 100%;
            background-color: #ffffff;
            border-radius: 40px;
            box-shadow: 0px 25px 70px rgba(1, 41, 112, 0.12);
            overflow: hidden;
            display: flex;
            min-height: 550px;
            position: relative;
        }

        /* Sisi Kiri: Form Login (Putih Bersih) */
        .login-left-side {
            flex: 1.1;
            padding: 60px 70px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background-color: #ffffff;
            z-index: 3;
        }

        /* SISI KANAN: DOMINAN PUTIH DENGAN CSS MESH GRADIENT (AURORA GLOW) */
        .login-right-side {
            flex: 0.9;
            background-color: #ffffff;
            /* Trik Mesh Gradient: Pendaran warna di sudut-sudut agar menyatu halus (anti-pelangi kaku) */
            background-image: 
                radial-gradient(at 85% 15%, rgba(126, 211, 72, 0.18) 0px, transparent 55%),   /* Glow Hijau Muda di atas kanan */
                radial-gradient(at 95% 85%, rgba(1, 55, 125, 0.16) 0px, transparent 60%),    /* Glow Biru Tua di bawah kanan */
                radial-gradient(at 35% 95%, rgba(0, 157, 209, 0.14) 0px, transparent 50%),   /* Glow Biru Muda di bawah kiri */
                radial-gradient(at 90% 50%, rgba(38, 177, 112, 0.1) 0px, transparent 45%);    /* Glow Hijau di tengah kanan */
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            z-index: 1;
            /* Batas lurus abu-abu sangat tipis dan elegan */
            border-left: 1px solid #f3f4f6; 
        }

        /* Desain Tulisan Welcome */
        .welcome-text {
            font-size: 32px;
            color: #2d3748;
            margin-bottom: 30px;
            line-height: 1.25;
            font-weight: 400;
        }
        .welcome-text span {
            font-weight: 500;
        }
        .welcome-text .highlight {
            color: var(--amcor-green);
            font-weight: 700;
        }

        /* Desain Label Form */
        .form-label-custom {
            font-size: 11px;
            font-weight: 800;
            color: #4a5568;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 6px;
            display: block;
        }

        /* Wrapper Input Field */
        .input-wrapper {
            position: relative;
            margin-bottom: 22px;
        }
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
        .input-field::placeholder {
            color: #cbd5e0;
        }
        .input-field:focus {
            outline: none;
            background-color: #ffffff;
            border-color: var(--amcor-dark-blue);
            box-shadow: 0 0 0 3px rgba(1, 55, 125, 0.1);
        }

        /* Eye Icon Toggle Password */
        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #a0aec0;
            cursor: pointer;
            font-size: 14px;
        }

        /* Tombol Login Bergradasi Hijau */
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
            margin-top: 10px;
        }
        .btn-login-gradient:hover {
            transform: translateY(-1.5px);
            box-shadow: 0px 12px 25px rgba(38, 177, 112, 0.25);
            opacity: 0.95;
        }

        /* Logo Amcor di sebelah Kanan */
        .visual-logo {
            max-width: 65%;
            max-height: 65%;
            object-fit: contain;
            /* Shadow super halus untuk efek kedalaman di atas background putih */
            filter: drop-shadow(0px 10px 20px rgba(0, 0, 0, 0.06));
            z-index: 3;
        }

        /* Footer Keterangan Sistem */
        .login-footer {
            margin-top: 40px;
            font-size: 11px;
            color: #a0aec0;
            text-align: center;
        }

        /* ==========================================
           RESPONSIVE DESIGN (SEMUA DEVICE)
           ========================================== */

        /* Tablet (max-width: 991px) */
        @media (max-width: 991px) {
            .login-wrapper {
                max-width: 750px;
            }
            .login-left-side {
                padding: 50px 45px;
            }
            .welcome-text {
                font-size: 28px;
            }
        }

        /* Mobile & Small Screens (max-width: 768px) */
        @media (max-width: 768px) {
            body {
                overflow-y: auto; 
                align-items: flex-start;
                padding: 30px 15px;
            }
            .login-wrapper {
                max-width: 100%;
            }
            .login-card {
                flex-direction: column;
                border-radius: 30px;
                min-height: auto;
            }
            .login-right-side {
                order: -1; 
                padding: 45px 35px;
                min-height: 180px;
                background-image: 
                    radial-gradient(at 50% 50%, rgba(126, 211, 72, 0.12) 0px, transparent 60%),
                    radial-gradient(at 90% 90%, rgba(1, 55, 125, 0.1) 0px, transparent 70%);
                border-left: none;
                border-bottom: 1px solid #f3f4f6;
            }
            .visual-logo {
                max-width: 140px;
            }
            .login-left-side {
                padding: 40px 30px;
                border-radius: 0 0 30px 30px;
            }
            .welcome-text {
                font-size: 26px;
                text-align: center;
                margin-bottom: 25px;
            }
            .login-footer {
                margin-top: 30px;
            }
        }
    </style>
</head>
<body>

    <div class="login-wrapper">
        <!-- Box Utama -->
        <div class="login-card">
            
            <!-- SISI KIRI: FORMULIR -->
            <div class="login-left-side">
                
                <!-- Judul -->
                <h2 class="welcome-text">
                    Hello there,<br>
                    <span>welcome</span> <span class="highlight">back!</span>
                </h2>

                <!-- Laravel Alert Error -->
                @if($errors->any())
                    <div class="alert alert-danger border-0 p-2 small mb-3 d-flex align-items-center gap-2" style="background-color: #fde1e1; color: #842029; border-radius: 8px;">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <!-- Form Login -->
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    
                    <!-- Input NIK -->
                    <div class="mb-2">
                        <label class="form-label-custom">NIK</label>
                        <div class="input-wrapper">
                            <i class="fa-regular fa-id-card input-icon"></i>
                            <input type="text" name="nik" class="input-field" required placeholder="Enter your NIK" value="{{ old('nik') }}" autofocus>
                        </div>
                    </div>
                    
                    <!-- Input Password -->
                    <div class="mb-2">
                        <label class="form-label-custom">Password</label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-lock input-icon"></i>
                            <input type="password" name="password" id="passwordInput" class="input-field" required placeholder="Enter your password">
                            <i class="fa-regular fa-eye-slash password-toggle" id="togglePassword"></i>
                        </div>
                    </div>
                    
                    <!-- Tombol Login -->
                    <button type="submit" class="btn-login-gradient text-uppercase">
                        LOGIN
                    </button>
                </form>

                <!-- Footer Informasi -->
                <div class="login-footer">
                    Tracking Sample System &bull; &copy; {{ date('Y') }} Amcor Flexibles
                </div>

            </div>

            <!-- SISI KANAN: DOMINAN PUTIH BERSIH + LEMBUTNYA GLOW WARNA KHAS AMCOR -->
            <div class="login-right-side">
                <!-- Logo Amcor -->
                <img src="{{ asset('logo1.png') }}" alt="Amcor Brand Icon" class="visual-logo">
            </div>

        </div>
    </div>

    <!-- Toggle Password Visibility Script -->
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const passwordInput = document.querySelector('#passwordInput');

        togglePassword.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>

</body>
</html>