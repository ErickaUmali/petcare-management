@extends('templates.base')

@section('styles')
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">
    <link rel="stylesheet" href="{{ asset('css/templates/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pets/create.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('js/pets/create.js') }}" defer></script>
@endsection

@section('title')
    Add Pet
@endsection

@section('body')
    @include('templates.navbar')
    <div class="dashboard-main-container">
        @include('templates.dashboard.aside')
        <main>
            <form action="{{ route('pets.store') }}" method="POST">
                @csrf
                <h1>Add Pet</h1>
                <div>
                    <label>Name</label>
                    <input type="text"
                        class="form-control form-control-sm {{ $errors->has('name') ? 'border-danger' : '' }}" name="name"
                        value="{{ old('name') }}" required>
                    @error('name')
                        <span>{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label>Birthday</label>
                    <input type="text" id="birthday"
                        class="form-control form-control-sm {{ $errors->has('birthday') ? 'border-danger' : '' }}"
                        name="birthday" value="{{ old('birthday') }}" required>
                    @error('birthday')
                        <span>{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label>Gender</label>
                    <select class="form-select form-select-sm {{ $errors->has('gender') ? 'border-danger' : '' }}"
                        name="gender" value="{{ old('gender') }}" required>
                        @foreach ($genders as $gender)
                            <option value="{{ $gender }}">{{ ucwords($gender) }}</option>
                        @endforeach
                    </select>
                    @error('gender')
                        <span>{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label>Species</label>
                    <select class="form-select form-select-sm {{ $errors->has('species_id') ? 'border-danger' : '' }}"
                        name="species_id" id="species" value="{{ old('species_id') }}" required>
                        @foreach ($species as $speciesItem)
                            <option value="{{ $speciesItem->id }}">{{ strtoupper($speciesItem->name) }}</option>
                        @endforeach
                    </select>
                    @error('species_id')
                        <span>{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label>Breed</label>
                    <select class="form-select form-select-sm {{ $errors->has('breed_id') ? 'border-danger' : '' }}"
                        name="breed_id" id="breed" value="{{ old('breed_id') }}" required>
                        @foreach ($breeds as $breed)
                            <option value="{{ $breed->id }}">{{ $breed->name }}</option>
                        @endforeach
                    </select>
                    @error('breed_id')
                        <span>{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label>Marking/Color</label>
                    <input type="text"
                        class="form-control form-control-sm {{ $errors->has('marking') ? 'border-danger' : '' }}"
                        name="marking" value="{{ old('marking') }}">
                    @error('marking')
                        <span>{{ $message }}</span>
                    @enderror
                </div>
                <div class="button-container">
                    <button type="submit" class="button">Add Pet</button>
                </div>
            </form>
        </main>
    </div>
@endsection
