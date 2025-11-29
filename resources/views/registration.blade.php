@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/registration_page.css') }}">

<br><br>
<div class="register-body">
    <div class="registration-content">
        <h2 id="create-account-header">Create Account</h2>
        <form method="POST" action="{{ route('register') }}" class="registration-form">
            @csrf
            <div class="input">
                <label for="fullname-input">Full Name:</label>
                <input type="text" id="fullname-input" name="fullname" value="{{ old('fullname') }}" required>
            </div>
            @error('fullname')
                <div class="error-text">{{ $message }}</div>
            @enderror
            
            <div class="input">
                <label for="username-input">Username:</label>
                <input type="text" id="username-input" name="username" value="{{ old('username') }}" required>
            </div>
            @error('username')
                <div class="error-text">{{ $message }}</div>
            @enderror
            
            <div class="input">
                <label for="age-input">Age:</label>
                <input type="number" id="age-input" name="age" value="{{ old('age') }}">
            </div>
            @error('age')
                <div class="error-text">{{ $message }}</div>
            @enderror
            
            <div class="input">
                <label for="email-input">Email:</label>
                <input type="email" id="email-input" name="email" value="{{ old('email') }}" required>
            </div>
            @error('email')
                <div class="error-text">{{ $message }}</div>
            @enderror
            
            <div class="input">
                <label for="password-input">Password:</label>
                <input type="password" id="password-input" name="password" required>
            </div>
            @error('password')
                <div class="error-text">{{ $message }}</div>
            @enderror
            
            <div class="input">
                <label for="confirmpass-input">Confirm password:</label>
                <input type="password" id="confirmpass-input" name="confirmpass" required>
            </div>
            @error('confirmpass')
                <div class="error-text">{{ $message }}</div>
            @enderror
            
            <br>
            <div class="submit-container">
                <input id="submit-button" type="submit" value="Register">
                <input id="clear-button" type="reset" value="Clear">
            </div>
        </form>
        <p class="account-exists">Already have an account? <a href="{{ route('login') }}" class="login-link">Click here</a></p>
    </div>
</div>

@push('scripts')
<script src="{{ asset('scripts/registration_validation.js') }}"></script>
@endpush
@endsection

