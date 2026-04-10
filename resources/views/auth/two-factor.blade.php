<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2FA Verification - SecureStaff</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="app-chrome"></div>
    <div class="app-grid"></div>
    <div class="login-screen">
        <div class="login-wrap" style="grid-template-columns: 1fr;">
            <section class="form">
                <h2>Email 2FA Verification</h2>
                <p class="muted">Enter the 6-digit code sent to <strong>{{ $email }}</strong>.</p>

                @if(session('status'))
                    <div class="panel" style="margin-bottom:16px; border-left:4px solid #21d4d8;">
                        {{ session('status') }}
                    </div>
                @endif
                @if($errors->any())
                    <div class="panel" style="margin-bottom:16px; border-left:4px solid #f97373;">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('auth.2fa.verify') }}" style="margin-bottom:12px;">
                    @csrf
                    <div class="form-group">
                        <label>Verification code</label>
                        <input class="form-control" type="text" name="code" maxlength="6" inputmode="numeric" pattern="[0-9]{6}" required>
                    </div>
                    <button class="btn" type="submit">Verify</button>
                </form>

                <form method="POST" action="{{ route('auth.2fa.resend') }}">
                    @csrf
                    <button class="btn" type="submit">Resend code</button>
                </form>
            </section>
        </div>
    </div>
</body>
</html>
