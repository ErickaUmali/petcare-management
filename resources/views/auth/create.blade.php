@extends('templates.base')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/auth/create.css') }}">
@endsection

@section('scripts')
    <script defer src="{{ asset('js/notif.js') }}"></script>
@endsection

@section('title')
    Register
@endsection

@section('body')
    <div class="alert alert-danger notification notif-desktop {{ count($errors->all()) > 0 ? 'show' : '' }}"
        data-index="1">
        <div class="notif">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </div>
        <button type="button" class="btn-close"></button>
    </div>
    <main>
        <section>
            <h1>Already A Member?</h1>
            <p>Sign in to use our wonderful services!</p>
            <div class="button-container">
                <a href="{{ route('auth.index') }}" class="button">Sign In</a>
            </div>
        </section>
        <form class="desktop" action="{{ route('auth.store') }}" method="POST">
            @csrf
            <h1>Create Your Account</h1>
            <div>
                <label>First Name</label>
                <input class="form-control form-control-sm {{ $errors->has('firstname') ? 'border-danger' : '' }}"
                    type="text" name="firstname" value="{{ old('firstname') }}" required>
            </div>
            <div>
                <label>Last Name</label>
                <input class="form-control form-control-sm {{ $errors->has('lastname') ? 'border-danger' : '' }}"
                    type="text" name="lastname" value="{{ old('lastname') }}" required>
            </div>
            <div>
                <label>Contact Number</label>
                <div class="input-group input-group-sm">
                    <span class="input-group-text">09</span>
                    <input class="form-control form-control-sm {{ $errors->has('contact') ? 'border-danger' : '' }}"
                        type="text" name="contact" value="{{ old('contact') }}" required>
                </div>
            </div>
            <div>
                <label>Security Questions</label>
                <select
                    class="form-select form-select-sm {{ $errors->has('security_question_id') ? 'border-danger' : '' }}"
                    name="security_question_id">
                    @foreach ($securityQuestions as $securityQuestion)
                        <option value="{{ $securityQuestion->id }}">{{ $securityQuestion->question }}?</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label>Answer <span class="text-primary">{{ '(Will be used for account recovery)' }}</span></label>
                <input class="form-control form-control-sm {{ $errors->has('answer') ? 'border-danger' : '' }}"
                    type="text" name="answer" value="{{ old('answer') }}" required>
            </div>
            <div>
                <label>Username</label>
                <input class="form-control form-control-sm {{ $errors->has('username') ? 'border-danger' : '' }}"
                    type="text" name="username" value="{{ old('username') }}" required>
            </div>
            <div>
                <label>Password</label>
                <input
                    class="form-control form-control-sm {{ $errors->has('password') || $errors->has('password_confirmation') ? 'border-danger' : '' }}"
                    type="password" name="password" required>
            </div>
            <div>
                <label>Confirm Password</label>
                <input class="form-control form-control-sm" type="password" name="password_confirmation" required>
            </div>
            <div class="button-container">
                <button type="submit" class="button">Sign Up</button>
            </div>
            <p>Already a member? <a href="{{ route('auth.index') }}">Login</a></p>
        </form>
    </main>
@endsection
