<!DOCTYPE html>
<html lang="en">

<head>

    <title>Sign In Page</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>

<body>
  @extends('default')
    <div class="container signin-container">
        <h2>Masuk</h2>
        <form method="POST" action="{{ route('signin.submit') }}">
            @csrf
            <input type="text" name="username" placeholder="Username atau Email" value="{{ old('username') }}" required>
            <input type="password" name="password" placeholder="Password" required>


            <button type="submit" class="signin-btn">Masuk</button>
        </form>

        @if (session('error'))
            <p class="text-danger text-center">{{ session('error') }}</p>
        @endif

        @if (session('success'))
            <p class="text-success text-center">{{ session('success') }}</p>
        @endif

        @if ($errors->any())
            <div class="text-danger text-center" style="margin-top: 15px;">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="signup-link">
            <p>Belum punya akun? <a href="{{ route('signup') }}">Daftar di sini</a></p>

        </div>
    </div>
</body>

</html>
