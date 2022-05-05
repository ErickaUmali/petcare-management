@extends('templates.base')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/templates/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('js/notif.js') }}" defer></script>
    <script src="{{ asset('js/feedback.js') }}" defer></script>
@endsection

@section('title')
    Home
@endsection

@section('body')
    @include('templates.navbar')

    <div class="alert alert-success notification notif-mobile {{ session()->has('storeSuccess') ? 'show' : '' }}"
        data-index="1">
        <div class="notif">
            @if (session()->has('storeSuccess'))
                {{ session()->get('storeSuccess') }}
            @endif
        </div>
        <button type="button" class="btn-close"></button>
    </div>

    <main>
        <section id="home">
            <div>
                <h1>Looking for a quality pet service?</h1>
                <a href="" class="button">Reserve Now</a>
            </div>
            <div class="image">
                <img src="{{ asset('images/home-img.png') }}" alt="">
            </div>
        </section>

        <section id="services">
            <h2> Services We Offered </h2>
            <div>
                <section>
                    <div>
                        <img src="{{ asset('images/f-icon1.png') }}" alt="">
                    </div>
                    <h3>Consultation</h3>
                    <p>Want to know how's your pet health? you can ask for consultation in here in our website.</p>
                    <a href="#" class="button">Read More</a>
                </section>
                <section>
                    <div>
                        <img src="{{ asset('images/f-icon2.png') }}" alt="">
                    </div>
                    <h3>Grooming</h3>
                    <p>Want to see your pet's best appearance? We are here to offer both hygienic and cleaning for your
                        pet.
                    </p>
                    <a href="#" class="button">Read More</a>
                </section>
                <section>
                    <div>
                        <img src="{{ asset('images/f-icon3.png') }}" alt="">
                    </div>
                    <h3>Surgery</h3>
                    <p>Need urgent surgery for your pet? We are here to offer a best quality surgery for your pet. </p>
                    <a href="#" class="button">Read More</a>
                </section>
            </div>
        </section>

        <section id="about">
            <h2> About Us </h2>
            <div class="image">
                <img src="{{ asset('images/about-img.png') }}" alt="">
            </div>
            <div>
                <h3>We Care For Your Four-legged Friends</h3>
                <p>
                    we serve pets of every type, age, and phase of life because we truly love
                    animals. We show it with every belly rub, long walk, scratch behind the ear, and treat we give. We’d
                    love to be your trusted sidekick for a healthy and happy pet because we know we can deliver trusted,
                    quality care and a professional, stress-free experience for you.
                </p>
            </div>
        </section>

        @if ($feedbacks->count())
            <section id="review">
                <h2> People's Review </h2>
                <div>
                    @foreach ($feedbacks as $feedback)
                        <section>
                            @if ($feedback->anonymous)
                                <div class="image">
                                    <span class="img"
                                        style="background-image: url('{{ asset('images/user-solid.svg') }}')"></span>
                                </div>
                                <h3>{{ substr($feedback->user->firstname, 0, 1) }}
                                    @for ($i = 1; $i < strlen($feedback->user->firstname); $i++)
                                        *
                                    @endfor
                                </h3>
                            @else
                                @if ($feedback->user->profile)
                                    <div class="image">
                                        <span class="img"
                                            style="background-image: url('{{ asset(str_replace('public/', 'storage/', $feedback->user->profile)) }}')"></span>
                                    </div>
                                @else
                                    <div class="image">
                                        <span class="img"
                                            style="background-image: url('{{ asset('images/user-solid.svg') }}')"></span>
                                    </div>
                                @endif
                                <h3>{{ $feedback->user->firstname }}</h3>
                            @endif

                            <div class="stars">
                                @for ($i = 0; $i < 5; $i++)
                                    @if ($i < $feedback->stars)
                                        <img src="{{ asset('images/star-solid.svg') }}" alt="">
                                    @else
                                        <img src="{{ asset('images/star-outline.svg') }}" alt="">
                                    @endif
                                @endfor
                            </div>
                            <p>{{ $feedback->message }}</p>
                        </section>
                    @endforeach
                </div>
            </section>
        @endif

        @if ($user)
            <section id="feedback">
                <h2>How's your experience with us?</h2>
                <div class="stars {{ $errors->has('stars') ? 'has-error' : '' }}">
                    @for ($i = 0; $i < 5; $i++)
                        @if ($i < intval(old('stars')))
                            <img src="{{ asset('images/star-solid.svg') }}" alt="">
                        @else
                            <img src="{{ asset('images/star-outline.svg') }}" alt="">
                        @endif
                    @endfor
                </div>
                @error('stars')
                    <span class="text-danger star-error">{{ $message }}</span>
                @enderror
                <form action="{{ route('feedbacks.store') }}" method="POST">
                    @csrf
                    <input type="number" name="stars" value="{{ old('stars') }}" hidden>
                    <div>
                        <div class="d-flex justify-content-end gap-2 m-1">
                            <p class="m-0">Anonymous</p>
                            <input class="form-check-input" type="checkbox" name="anonymous">
                        </div>
                        <textarea class="form-control {{ $errors->has('message') ? 'border-danger' : '' }}" rows="3" name="message"
                            placeholder="Enter your feedback here...">{{ old('message') }}</textarea>
                        @error('message')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="button-container">
                        <button type="submit" class="button">Send Feedback</button>
                    </div>
                </form>
            </section>
        @endif

        <footer>
            &copy; Copyright 2022 Thesis Programmers
        </footer>
    </main>
@endsection
