@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/login_page.css') }}">

<br><br>
<div class="login-body">
    <div class="login-content">
        <h2>Login to ReykenTraders</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="{{ old('username') }}" required><br><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>

            <button class="login-button" type="submit">Login</button>
            @if($errors->has('login'))
                <div style="color: red; margin-top: 10px;">{{ $errors->first('login') }}</div>
            @endif
        </form>
        <div class="no-account">
            <p>Don't have an account yet? <a href="{{ route('register') }}">Click here</a></p>
        </div>
    </div>
</div>
@endsection

