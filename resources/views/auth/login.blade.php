<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SecureStaff Login</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="app-chrome"></div>
    <div class="app-grid"></div>
    <div class="login-screen">
    <div class="login-wrap">
        <section class="hero">
            <h1>SharpInsights</h1>
            <p>Employee management system with integrated password policy enforcement.</p>
            <div class="badge">Strong passwords, attendance, leave, payroll, and notices in one portal.</div>
            <div class="badge">Laravel 10 + Sanctum authentication with policy-aware password changes.</div>
            <div class="badge">Admin-configurable security controls and audit logging.</div>
        </section>

        <section class="form">
            <h2>Sign in</h2>
            <p class="muted">Use your company email and password.</p>

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

            <form method="POST" action="{{ route('login.attempt') }}">
                @csrf
                <label>Email</label>
                <input type="email" name="email" placeholder="hr.admin@securestaff.test" required>

                <label>Password</label>
                <input type="password" name="password" placeholder="••••••••••••" data-password-toggle="true" required>

                <button type="submit" class="btn">Login</button>
            </form>

            <div class="policy">
                <strong>Password policy preview</strong>
                <ul>
                    <li>Minimum 12 characters</li>
                    <li>Uppercase, lowercase, number, and symbol required</li>
                    <li>Recent password reuse blocked</li>
                    <li>Password change required every 90 days</li>
                </ul>
            </div>
        </section>
    </div>
    </div>
</body>
</html>
