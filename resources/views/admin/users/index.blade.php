@extends('layouts.app')

@section('page-title', 'Users')
@section('page-subtitle', 'Create and manage employee accounts')

@section('content')
    @if($errors->any())
        <div class="panel" style="margin-bottom:16px; border-left:4px solid #f97373;">
            <strong>Unable to create user.</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="split">
        <div class="panel">
            <h3>Create User</h3>
            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf

                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input id="name" class="form-control" type="text" name="name" value="{{ old('name') }}" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required>
                </div>

                <div class="form-group">
                    <label for="department">Department</label>
                    <select id="department" class="form-control" name="department" required>
                        <option value="">Select department</option>
                        @foreach($departments as $department)
                            <option value="{{ $department }}" @selected(old('department') === $department)>{{ $department }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="role">Role</label>
                    <select id="role" class="form-control" name="role" required>
                        <option value="employee" @selected(old('role') === 'employee')>Employee</option>
                        <option value="admin" @selected(old('role') === 'admin')>Admin</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="password">Temporary Password</label>
                    <input id="password" class="form-control" type="password" name="password" data-password-toggle="true" data-min-length="{{ $policy->min_length }}" required>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" data-password-toggle="true" required>
                </div>

                <div class="panel" style="margin-bottom:16px;">
                    <strong>Password requirements checklist</strong>
                    <ul style="list-style:none; padding-left:0; margin:12px 0 0;">
                        <li style="margin-bottom:8px;">
                            <label><input id="rule-length" type="checkbox" disabled> Minimum length ({{ $policy->min_length }} characters)</label>
                        </li>
                        @if($policy->require_uppercase)
                            <li style="margin-bottom:8px;">
                                <label><input id="rule-uppercase" type="checkbox" disabled> At least one uppercase letter</label>
                            </li>
                        @endif
                        @if($policy->require_lowercase)
                            <li style="margin-bottom:8px;">
                                <label><input id="rule-lowercase" type="checkbox" disabled> At least one lowercase letter</label>
                            </li>
                        @endif
                        @if($policy->require_numeric)
                            <li style="margin-bottom:8px;">
                                <label><input id="rule-numeric" type="checkbox" disabled> At least one number</label>
                            </li>
                        @endif
                        @if($policy->require_symbol)
                            <li style="margin-bottom:8px;">
                                <label><input id="rule-symbol" type="checkbox" disabled> At least one symbol</label>
                            </li>
                        @endif
                        <li>
                            <label><input id="rule-confirmed" type="checkbox" disabled> Password and confirmation match</label>
                        </li>
                    </ul>
                </div>

                <button class="btn" type="submit">Create User</button>
            </form>
        </div>

        <div class="panel">
            <h3>Existing Users</h3>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Department</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ ucfirst($user->role) }}</td>
                            <td>{{ $user->department ?: '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="muted">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        (() => {
            const passwordInput = document.getElementById('password');
            const confirmInput = document.getElementById('password_confirmation');

            if (!passwordInput || !confirmInput) return;

            const minLength = Number.parseInt(passwordInput.dataset.minLength || '0', 10);
            const checks = {
                length: document.getElementById('rule-length'),
                uppercase: document.getElementById('rule-uppercase'),
                lowercase: document.getElementById('rule-lowercase'),
                numeric: document.getElementById('rule-numeric'),
                symbol: document.getElementById('rule-symbol'),
                confirmed: document.getElementById('rule-confirmed'),
            };

            const updateChecklist = () => {
                const password = passwordInput.value || '';
                const confirmation = confirmInput.value || '';

                if (checks.length) checks.length.checked = password.length >= minLength;
                if (checks.uppercase) checks.uppercase.checked = /[A-Z]/.test(password);
                if (checks.lowercase) checks.lowercase.checked = /[a-z]/.test(password);
                if (checks.numeric) checks.numeric.checked = /[0-9]/.test(password);
                if (checks.symbol) checks.symbol.checked = /[\W_]/.test(password);
                if (checks.confirmed) checks.confirmed.checked = password.length > 0 && password === confirmation;
            };

            passwordInput.addEventListener('input', updateChecklist);
            confirmInput.addEventListener('input', updateChecklist);
            updateChecklist();
        })();
    </script>
@endsection
