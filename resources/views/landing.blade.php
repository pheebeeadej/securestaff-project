<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'SecureStaff') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="landing-body">
    <div class="landing-bg"></div>

    <header class="landing-header">
        <div class="landing-nav">
            <a class="landing-brand" href="{{ route('landing') }}">
                <span class="landing-mark">SS</span>
                <span class="landing-name">{{ config('app.name', 'SecureStaff') }}</span>
            </a>

            <nav class="landing-links">
                <a href="#features">Features</a>
                <a href="#modules">Modules</a>
                <a href="#contact">Contact</a>
            </nav>

            <div class="landing-actions">
                <a class="landing-btn landing-btn-ghost" href="{{ route('login') }}">Login</a>
            </div>
        </div>
    </header>

    <main class="landing-main">
        <section class="landing-hero">
            <div class="landing-hero-card">
                <div class="landing-badge">SecureStaff Portal</div>
                <h1>
                    A platform to <span class="landing-em">manage staff</span><br>
                    and <span class="landing-em">secure access</span>.
                </h1>
                <p>
                    Attendance, leave, notices and payroll—wrapped with password policy enforcement and two‑factor login.
                </p>

                <div class="landing-cta">
                    <a class="landing-btn landing-btn-primary" href="{{ route('login') }}">Login to continue</a>
                    <a class="landing-btn landing-btn-soft" href="#features">Explore features</a>
                </div>
            </div>

            <div class="landing-hero-visual" aria-hidden="true">
                <div class="landing-visual-glass">
                    <div class="landing-visual-top">
                        <div class="landing-pill">Attendance</div>
                        <div class="landing-pill">Payroll</div>
                        <div class="landing-pill">Security</div>
                    </div>
                    <div class="landing-visual-title">Red theme enabled</div>
                    <div class="landing-visual-sub">Modern UI inspired by your reference design.</div>
                    <div class="landing-visual-bars">
                        <div class="landing-bar" style="--w: 92%"></div>
                        <div class="landing-bar" style="--w: 74%"></div>
                        <div class="landing-bar" style="--w: 61%"></div>
                    </div>
                </div>
            </div>
        </section>

        <section id="features" class="landing-section">
            <h2>Features</h2>
            <div class="landing-grid">
                <div class="landing-tile">
                    <div class="landing-tile-title">Two‑Factor Login</div>
                    <div class="landing-tile-text">OTP verification for safer sign‑ins.</div>
                </div>
                <div class="landing-tile">
                    <div class="landing-tile-title">Password Policy</div>
                    <div class="landing-tile-text">History, expiry, complexity, and lockout threshold.</div>
                </div>
                <div class="landing-tile">
                    <div class="landing-tile-title">Operational Modules</div>
                    <div class="landing-tile-text">Attendance, leave requests, notices, and payroll summaries.</div>
                </div>
            </div>
        </section>

        <section id="modules" class="landing-section">
            <h2>Modules</h2>
            <div class="landing-grid">
                <div class="landing-tile"><div class="landing-tile-title">Dashboard</div><div class="landing-tile-text">Overview of operations and security posture.</div></div>
                <div class="landing-tile"><div class="landing-tile-title">Attendance</div><div class="landing-tile-text">Clock in/out and daily status tracking.</div></div>
                <div class="landing-tile"><div class="landing-tile-title">Leave</div><div class="landing-tile-text">Request, review and manage time off.</div></div>
            </div>
        </section>

        <footer id="contact" class="landing-footer">
            <div class="landing-footer-card">
                <div>
                    <div class="landing-footer-title">{{ config('app.name', 'SecureStaff') }}</div>
                    <div class="landing-footer-text">Staff operations + security policy engine</div>
                </div>
                <a class="landing-btn landing-btn-primary" href="{{ route('login') }}">Login</a>
            </div>
        </footer>
    </main>
</body>
</html>

