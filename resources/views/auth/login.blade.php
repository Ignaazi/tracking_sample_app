<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Amcor System Scanner</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --nice-blue: #4154f1;
            --nice-dark: #012970;
            --bg-light: #f6f9ff;
        }
        body { 
            font-family: "Nunito", sans-serif; 
            background-color: var(--bg-light); 
            height: 100vh; 
            display: flex; 
            align-items: center; 
            justify-content: center;
            margin: 0;
        }
        .login-card { 
            border: none; 
            border-radius: 8px; 
            width: 100%;
            max-width: 420px; 
            background-color: #ffffff;
            box-shadow: 0px 0px 30px rgba(1, 41, 112, 0.08) !important;
        }
        /* Style Kotak Logo Sesuai Request */
        .logo-box {
            width: 65px;
            height: 65px;
            background: #ffffff;
            border: 1px solid #eaeaea;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px auto;
            box-shadow: 0px 4px 12px rgba(1, 41, 112, 0.04);
            overflow: hidden;
        }
        .form-control {
            font-size: 14px;
            padding: 10px 12px;
            border-color: #d0d4fc;
            border-radius: 6px;
            transition: all 0.2s ease;
        }
        .form-control:focus {
            border-color: var(--nice-blue);
            box-shadow: 0 0 0 0.25rem rgba(65, 84, 241, 0.1);
        }
        .btn-login {
            background-color: var(--nice-blue);
            border-color: var(--nice-blue);
            font-size: 14px;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            border-radius: 6px;
        }
        .btn-login:hover {
            background-color: #2a3df0;
            border-color: #2a3df0;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(65, 84, 241, 0.3);
        }
    </style>
</head>
<body>

    <div class="card login-card p-4 mx-3">
        
        <div class="text-center mb-4">
            <div class="logo-box">
                <img src="{{ asset('logo1.png') }}" alt="Logo Amcor" class="img-fluid" style="max-height: 85%; max-width: 85%; object-fit: contain;">
            </div>
            
            <h3 class="fw-bold m-0" style="color: var(--nice-dark); font-size: 22px;">AMCOR </h3>
            <span class="text-muted" style="font-size: 13px;">Tracking Sample System</span>
        </div>

        @if($errors->any())
            <div class="alert alert-danger border-0 p-2.5 small mb-3 text-center d-flex align-items-center justify-content-center gap-2" style="background-color: #fde1e1; color: #842029; border-radius: 6px;">
                <i class="fa-solid fa-circle-exclamation"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label class="form-label fw-bold text-secondary mb-1" style="font-size: 13px;">NIK (Nomor Induk Karyawan)</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted" style="border-color: #d0d4fc;"><i class="fa-regular fa-id-card"></i></span>
                    <input type="text" name="nik" class="form-control border-start-0" required placeholder="Masukkan NIK Anda" value="{{ old('nik') }}" autofocus>
                </div>
            </div>
            
            <div class="mb-4">
                <label class="form-label fw-bold text-secondary mb-1" style="font-size: 13px;">Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted" style="border-color: #d0d4fc;"><i class="fa-solid fa-lock"></i></span>
                    <input type="password" name="password" class="form-control border-start-0" required placeholder="••••••••">
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary btn-login w-100 fw-bold py-2 shadow-sm text-uppercase">
                <i class="fa-solid fa-right-to-bracket me-2"></i>Sign In
            </button>
        </form>
    </div>

</body>
</html>