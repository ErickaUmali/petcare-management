@extends('templates.base')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/templates/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pets/index.css') }}">
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
            <h1>My Pets</h1>
            <section>
                <div>
                    <span>Name</span>
                    <span>Gender</span>
                    <span>Birthday</span>
                    <span>Species</span>
                </div>
                @forelse ($pets as $pet)
                    <a href="{{ route('pets.show', $pet->id) }}">
                        @if ($pet->profile)
                            <span class="image"
                                style="background-image: url('{{ asset(str_replace('public/', 'storage/', $pet->profile)) }}')"></span>
                        @else
                            <span class="image"></span>
                        @endif
                        <span>{{ $pet->name }}</span>
                        <span>{{ ucwords($pet->gender) }}</span>
                        <span>{{ \Carbon\Carbon::parse($pet->birthday)->toFormattedDateString() }}</span>
                        <span>{{ ucwords(explode('/', $pet->species->name)[0]) }}/{{ ucwords(explode('/', $pet->species->name)[1]) }}</span>
                    </a>
                @empty
                    <p class="p-2 text-center">You currently have no pets.</p>
                @endforelse
            </section>
        </main>
    </div>
@endsection
