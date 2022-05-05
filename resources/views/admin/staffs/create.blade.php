@extends('templates.base')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/templates/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin/staffs/create.css') }}">
@endsection

@section('scripts')
@endsection

@section('title')
    Staffs
@endsection

@section('body')
    @include('templates.navbar')
    <div class="dashboard-main-container">
        @include('templates.dashboard.aside')
        <main>
            <header>Add Staff</header>
            <form action="{{ route('staffs.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div>
                        <label>First Name</label>
                        <input class="form-control form-control-sm {{ $errors->has('firstname') ? 'border-danger' : '' }}"
                            type="text" name="firstname" value="{{ old('firstname') }}" required>
                        @error('firstname')
                            <span>{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label>Last Name</label>
                        <input class="form-control form-control-sm {{ $errors->has('lastname') ? 'border-danger' : '' }}"
                            type="text" name="lastname" value="{{ old('lastname') }}" required>
                        @error('lastname')
                            <span>{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label>Contact Number</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text">09</span>
                            <input
                                class="form-control form-control-sm {{ $errors->has('contact') ? 'border-danger' : '' }}"
                                type="text" name="contact" value="{{ old('contact') }}" required>
                        </div>
                        @error('contact')
                            <span>{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label>Security Questions</label>
                        <select
                            class="form-select form-select-sm {{ $errors->has('security_question_id') ? 'border-danger' : '' }}"
                            name="security_question_id">
                            @foreach ($securityQuestions as $securityQuestion)
                                <option value="{{ $securityQuestion->id }}">
                                    {{ $securityQuestion->question }}?</option>
                            @endforeach
                        </select>
                        @error('security_question_id')
                            <span>{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label>Answer <span
                                class="text-primary">{{ '(Will be used for account recovery)' }}</span></label>
                        <input class="form-control form-control-sm {{ $errors->has('answer') ? 'border-danger' : '' }}"
                            type="text" name="answer" value="{{ old('answer') }}" required>
                        @error('answer')
                            <span>{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label>Username</label>
                        <input class="form-control form-control-sm {{ $errors->has('username') ? 'border-danger' : '' }}"
                            type="text" name="username" value="{{ old('username') }}" required>
                        @error('username')
                            <span>{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label>Password</label>
                        <input
                            class="form-control form-control-sm {{ $errors->has('password') || $errors->has('password_confirmation') ? 'border-danger' : '' }}"
                            type="password" name="password" required>
                        @error('password')
                            <span>{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label>Confirm Password</label>
                        <input class="form-control form-control-sm" type="password" name="password_confirmation" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </main>
    </div>
@endsection
