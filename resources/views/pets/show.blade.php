@extends('templates.base')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/templates/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pets/show.css') }}">
@endsection

@section('scripts')
@endsection

@section('title')
    Add Pet
@endsection

@section('body')
    @include('templates.navbar')
    <div class="dashboard-main-container">
        @include('templates.dashboard.aside')
        <main>
            <header>Pet Details</header>
            <section>
                @if ($pet->profile)
                    <div class="image">
                        <span class="img"
                            style="background-image: url('{{ asset(str_replace('public/', 'storage/', $pet->profile)) }}')">
                        </span>
                    </div>
                @else
                    <div class="image">
                        <span>Profile Here</span>
                    </div>
                @endif
                <div class="details">
                    <p>{{ $pet->name }}</p>
                    <div>
                        <span>Gender: </span>
                        <span>{{ ucwords($pet->gender) }}</span>
                    </div>
                    <div>
                        <span>Birthday: </span>
                        <span>{{ \Carbon\Carbon::parse($pet->birthday)->toFormattedDateString() }}</span>
                    </div>
                    <div>
                        <span>Species: </span>
                        <span>{{ ucwords(explode('/', $pet->species->name)[0]) }}/{{ ucwords(explode('/', $pet->species->name)[1]) }}</span>
                    </div>
                    <div>
                        <span>Breed: </span>
                        @if (str_contains($pet->breed->name, '/'))
                            <span>{{ ucwords(strtolower(explode('/', $pet->breed->name)[0])) }}/{{ ucwords(strtolower(explode('/', $pet->breed->name)[1])) }}</span>
                        @else
                            <span>{{ ucwords(strtolower($pet->breed->name)) }}</span>
                        @endif
                    </div>
                </div>
                <form action="{{ route('pets.update', $pet->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div>
                        <label>Add Pet Profile</label>
                        <input class="form-control {{ $errors->has('profile') ? 'border-danger' : '' }}" type="file"
                            name="profile">
                        @error('profile')
                            <span>{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="button-container">
                        <button class="button" type="submit">Upload</button>
                    </div>
                </form>
            </section>
        </main>
    </div>
@endsection
