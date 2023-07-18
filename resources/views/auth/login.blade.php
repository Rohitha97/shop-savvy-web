@extends('layouts.app')

@section('content')
    <main class="main-content  mt-0 ">
        <section>
            <div class="page-header min-vh-75">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
                            <div class="card mt-8">
                                <div class="card-header pb-0 text-left bg-transparent text-center">
                                    <img class="w-25" src="{{ asset('assets/img/logo.png') }}" alt="">
                                    <h3 class="font-weight-bolder text-primary text-gradient">Welcome back</h3>
                                    <p class="mb-0"><small>Enter your email and password to sign in</small></p>
                                </div>
                                <br>
                                <div class="card-body">
                                    <form role="form" method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <label>Email</label>
                                        <div class="mb-3">
                                            <input aria-label="Email" aria-describedby="email-addon" id="email"
                                                type="email" class="form-control @error('email') is-invalid @enderror"
                                                name="email" value="{{ old('email') }}" required autocomplete="email"
                                                autofocus>

                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <label>Password</label>
                                        <div class="mb-3">
                                            <input aria-label="Password" aria-describedby="password-addon" id="password"
                                                type="password" class="form-control @error('password') is-invalid @enderror"
                                                name="password" required autocomplete="current-password">

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn bg-primary text-white w-100 mt-4 mb-0">Sign
                                                in</button>
                                        </div>
                                        <div class="text-center mt-3">
                                            <a href="{{ route('password.request') }}" class="text-black">
                                                <small>Forgot password?</small>
                                            </a>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('layouts.footer')
@endsection
