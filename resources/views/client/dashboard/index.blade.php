@extends('templates.base')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/templates/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/client/dashboard/index.css') }}">
@endsection

@section('scripts')
@endsection

@section('title')
    Client Dashboard
@endsection

@section('body')
    @include('templates.navbar')
    <div class="dashboard-main-container">
        @include('templates.dashboard.aside')
        <main>
            <header>Profile</header>
            <section>
                @if ($user->profile)
                    <div class="image">
                        <span class="img"
                            style="background-image: url('{{ asset(str_replace('public/', 'storage/', $user->profile)) }}')"></span>
                    </div>
                @else
                    <div class="image">
                        <span>No Profile</span>
                    </div>
                @endif
                <div class="details">
                    <section>
                        <div>
                            <p>{{ $user->firstname }} {{ $user->lastname }}</p>
                            <p class="text-primary">{{ $user->username }}</p>
                        </div>
                        <div>
                            <span>PETS</span>
                            <p>{{ $user->pets->count() }}</p>
                        </div>
                        <div>
                            <span>RESERVATIONS</span>
                            <p>{{ $user->reservations->count() }}</p>
                        </div>
                    </section>
                    <section>
                        <div>
                            <span>Contact: </span>
                            <span>{{ $user->contact }}</span>
                        </div>
                        <div>
                            <span>Firstname: </span>
                            <span>{{ $user->firstname }}</span>
                        </div>
                        <div>
                            <span>Lastname: </span>
                            <span>{{ $user->lastname }}</span>
                        </div>
                        <div>
                            <span>Security Question: </span>
                            <span>{{ $user->securityQuestion->question }}?</span>
                        </div>
                    </section>
                    <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div>
                            @if ($user->profile)
                                <label>Change User Profile</label>
                            @else
                                <label>Add User Profile</label>
                            @endif
                            <input
                                class="form-control form-control-sm {{ $errors->has('profile') ? 'border-danger' : '' }}"
                                type="file" name="profile">
                            @error('profile')
                                <span>{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="button-container">
                            <button class="button" type="submit">Upload</button>
                        </div>
                    </form>
                </div>
            </section>
        </main>
    </div>
@endsection
