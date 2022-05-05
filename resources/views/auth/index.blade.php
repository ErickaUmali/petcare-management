@extends('templates.base')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/auth/index.css') }}">
@endsection

@section('scripts')
    <script defer src="{{ asset('js/notif.js') }}"></script>
@endsection

@section('title')
    Login
@endsection

@section('body')
    <div class="alert alert-danger notification notif-mobile {{ $errors->has('credentials') ? 'show' : '' }}"
        data-index="1">
        <div class="notif">
            @error('credentials')
                {{ $message }}
            @enderror
        </div>
        <button type="button" class="btn-close"></button>
    </div>

    <div class="alert alert-success notification notif-mobile {{ session()->has('storeSuccess') ? 'show' : '' }}"
        data-index="2">
        <div class="notif">
            @if (session()->has('storeSuccess'))
                {{ session()->get('storeSuccess') }}
            @endif
        </div>
        <button type="button" class="btn-close"></button>
    </div>

    <main>
        <form action="{{ route('auth.login') }}" method="POST">
            @csrf
            <h1>Login to Your Account</h1>
            <div>
                <label>Username or Contact</label>
                <input type="text" class="form-control" name="username" required>
            </div>
            <div>
                <label>Password</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <div class="button-container">
                <button type="submit" class="button">Sign In</button>
            </div>
            <p>New Here? <a href="{{ route('auth.create') }}">Sign Up</a></p>
        </form>
        <section>
            <h1>New Here?</h1>
            <p>Sign up to use our wonderful services!</p>
            <div class="button-container">
                <a href="{{ route('auth.create') }}" class="button">Sign Up</a>
            </div>
        </section>
    </main>
@endsection
