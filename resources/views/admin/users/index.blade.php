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
                    <input id="password" class="form-control" type="password" name="password" required>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required>
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
@endsection
