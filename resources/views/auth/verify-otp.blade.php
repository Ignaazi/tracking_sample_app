<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP - Amcor System Scanner</title>
    <!-- Bootstrap 5 & FontAwesome 6 -->
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
            --amcor-orange: #f97316;
            --amcor-orange-hover: #ea580c;
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
            padding: 40px 60px;
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
            font-size: 28px;
            color: #2d3748;
            margin-bottom: 4px;
            line-height: 1.25;
            font-weight: 400;
        }
        .welcome-text .highlight { color: var(--amcor-green); font-weight: 700; }

        .otp-container {
            display: flex;
            gap: 12px;
            justify-content: center;
            margin: 18px 0 12px 0;
        }

        .otp-input {
            width: 55px;
            height: 60px;
            text-align: center;
            font-size: 24px;
            font-weight: 800;
            color: var(--amcor-dark-blue);
            background-color: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            transition: all 0.25s ease-in-out;
        }

        .otp-input:focus {
            outline: none;
            background-color: #ffffff;
            border-color: var(--amcor-green);
            box-shadow: 0 0 0 4px rgba(38, 177, 112, 0.15);
        }

        .btn-login-gradient {
            background: linear-gradient(90deg, var(--amcor-light-green) 0%, var(--amcor-green) 100%);
            border: none;
            color: #ffffff;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.5px;
            padding: 12px;
            border-radius: 25px;
            width: 100%;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0px 8px 20px rgba(38, 177, 112, 0.15);
            margin-top: 5px;
        }
        .btn-login-gradient:hover {
            transform: translateY(-1.5px);
            box-shadow: 0px 12px 25px rgba(38, 177, 112, 0.25);
            opacity: 0.95;
        }

        /* Tombol Oranye Kecil di Pojok Kanan */
        .btn-resend-orange {
            background-color: var(--amcor-orange);
            color: #ffffff;
            font-size: 11px;
            font-weight: 700;
            padding: 6px 14px;
            border-radius: 20px;
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0px 4px 12px rgba(249, 115, 22, 0.25);
            transition: all 0.25s ease;
        }

        .btn-resend-orange:hover:not(.disabled) {
            background-color: var(--amcor-orange-hover);
            color: #ffffff;
            transform: translateY(-1px);
            box-shadow: 0px 6px 15px rgba(249, 115, 22, 0.35);
        }

        .btn-resend-orange.disabled {
            background-color: #cbd5e0;
            color: #94a3b8;
            box-shadow: none;
            cursor: not-allowed;
            pointer-events: none;
            opacity: 0.7;
        }

        .timer-badge {
            font-size: 12px;
            font-weight: 700;
            color: #0369a1;
            background-color: #e0f2fe;
            padding: 6px 14px;
            border-radius: 20px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .visual-logo {
            max-width: 65%;
            max-height: 65%;
            object-fit: contain;
            filter: drop-shadow(0px 10px 20px rgba(0, 0, 0, 0.06));
            z-index: 3;
        }

        .login-footer {
            margin-top: 20px;
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
                    Verifikasi Kode<br>
                    <span class="highlight">OTP</span>
                </h2>
                <p class="text-muted mb-2" style="font-size: 12.5px; line-height: 1.4;">
                    Masukkan 5 digit kode verifikasi yang telah dikirimkan ke email Anda.
                </p>

                <!-- Status Timer Bar -->
                <div id="timerAlert" class="alert alert-info border-0 p-2 small mb-2 d-flex align-items-center justify-content-between" style="background-color: #e0f2fe; color: #0369a1; border-radius: 10px;">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-hourglass-half fa-spin" style="--fa-animation-duration: 2s;"></i>
                        <span class="fw-semibold">Kode berlaku selama:</span>
                    </div>
                    <span id="timer" class="fw-bold fs-6 font-monospace">01:00</span>
                </div>

                <!-- Status Expired Bar -->
                <div id="expiredAlert" class="alert alert-warning border-0 p-2 small mb-2 d-none align-items-center gap-2" style="background-color: #fef3c7; color: #92400e; border-radius: 10px;">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span>OTP kadaluwarsa! Silakan minta kode baru.</span>
                </div>

                <!-- Alert Error Laravel -->
                @if($errors->any())
                    <div class="alert alert-danger border-0 p-2 small mb-2 d-flex align-items-center gap-2" style="background-color: #fde1e1; color: #842029; border-radius: 8px;">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <!-- Alert Sukses Laravel -->
                @if(session('success'))
                    <div class="alert alert-success border-0 p-2 small mb-2 d-flex align-items-center gap-2" style="background-color: #e1fdf0; color: #0f5132; border-radius: 8px;">
                        <i class="fa-solid fa-circle-check"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <form action="{{ route('password.verify_otp') }}" method="POST" id="otpForm">
                    @csrf

                    <!-- Hidden Input 5-Digit OTP -->
                    <input type="hidden" name="otp" id="fullOtp">

                    <!-- 5 Box OTP -->
                    <div class="otp-container">
                        <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" autofocus required>
                        <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                        <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                        <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                        <input type="text" class="otp-input" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                    </div>

                    <button type="submit" class="btn-login-gradient text-uppercase">
                        VERIFIKASI OTP
                    </button>
                </form>

                <!-- Tombol Oranye Kecil di Pojok Kanan -->
                <div class="d-flex justify-content-end align-items-center mt-3">
                    <a href="{{ route('password.request') }}" id="resendBtn" class="btn-resend-orange disabled">
                        <i class="fa-solid fa-paper-plane"></i> Kirim Ulang OTP
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

    <!-- JavaScript Handling Timer & OTP Inputs -->
    <script>
        // 1. COUNTDOWN TIMER (1 MENIT)
        let timeLeft = 60;
        const timerDisplay = document.getElementById('timer');
        const timerAlert = document.getElementById('timerAlert');
        const expiredAlert = document.getElementById('expiredAlert');
        const resendBtn = document.getElementById('resendBtn');

        const countdown = setInterval(() => {
            timeLeft--;

            let minutes = Math.floor(timeLeft / 60);
            let seconds = timeLeft % 60;

            minutes = minutes < 10 ? '0' + minutes : minutes;
            seconds = seconds < 10 ? '0' + seconds : seconds;

            timerDisplay.textContent = `${minutes}:${seconds}`;

            if (timeLeft <= 0) {
                clearInterval(countdown);
                
                // Switch Alert ke Expired
                timerAlert.classList.add('d-none');
                expiredAlert.classList.remove('d-none');
                expiredAlert.classList.add('d-flex');

                // Aktifkan Tombol Oranye Kirim Ulang
                resendBtn.classList.remove('disabled');
            }
        }, 1000);

        // 2. INPUT AUTO FOCUS & PASTE HANDLER
        const inputs = document.querySelectorAll('.otp-input');
        const form = document.getElementById('otpForm');
        const fullOtpInput = document.getElementById('fullOtp');

        inputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                input.value = input.value.replace(/[^0-9]/g, '');

                if (input.value && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
            });

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && !input.value && index > 0) {
                    inputs[index - 1].focus();
                }
            });

            input.addEventListener('paste', (e) => {
                e.preventDefault();
                const pastedData = e.clipboardData.getData('text').replace(/[^0-9]/g, '').slice(0, 5);
                
                pastedData.split('').forEach((char, i) => {
                    if (inputs[i]) {
                        inputs[i].value = char;
                    }
                });

                if (pastedData.length > 0) {
                    const lastIndex = Math.min(pastedData.length - 1, inputs.length - 1);
                    inputs[lastIndex].focus();
                }
            });
        });

        form.addEventListener('submit', (e) => {
            let otpValue = '';
            inputs.forEach(input => {
                otpValue += input.value;
            });

            if (otpValue.length !== 5) {
                e.preventDefault();
                alert('Silakan masukkan 5 digit kode OTP lengkap!');
                return;
            }

            fullOtpInput.value = otpValue;
        });
    </script>

</body>
</html>