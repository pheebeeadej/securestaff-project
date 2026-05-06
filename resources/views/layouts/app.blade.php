<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'SecureStaff') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="app-chrome"></div>
    <div class="app-grid"></div>
    <div class="shell">
        <aside>
            <div class="brand">
                <h2>SecureStaff</h2>
                <p class="muted">Employee portal + security policy engine</p>
            </div>
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('attendance.index') }}" class="{{ request()->routeIs('attendance.*') ? 'active' : '' }}">Attendance</a>
            <a href="{{ route('leave.index') }}" class="{{ request()->routeIs('leave.*') ? 'active' : '' }}">Leave Requests</a>
            <a href="{{ route('notices.index') }}" class="{{ request()->routeIs('notices.*') ? 'active' : '' }}">Notices</a>
            <a href="{{ route('payroll.index') }}" class="{{ request()->routeIs('payroll.*') ? 'active' : '' }}">Payroll</a>
            <a href="{{ route('profile.index') }}" class="{{ request()->routeIs('profile.*') ? 'active' : '' }}">Profile</a>
            @if(auth()->user()?->isAdmin())
                <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">Users</a>
                <a href="{{ route('security.policies.index') }}" class="{{ request()->routeIs('security.*') ? 'active' : '' }}">Security</a>
            @endif
        </aside>

        <main>
            <div class="topbar">
                <div>
                    <h1>@yield('page-title')</h1>
                    <p class="muted">@yield('page-subtitle')</p>
                </div>
                <div style="display:flex; gap:12px; align-items:center;">
                    <span class="status">{{ auth()->user()->role ?? 'guest' }}</span>
                    @auth
                        <form method="POST" action="{{ route('logout') }}">@csrf<button class="btn">Logout</button></form>
                    @endauth
                </div>
            </div>

            @if(session('status'))
                <div class="panel" style="margin-bottom:16px; border-left:4px solid var(--accent);">{{ session('status') }}</div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>
