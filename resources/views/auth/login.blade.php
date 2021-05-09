@extends('layouts.app')

@section('content')
{{-- Breadcrumb --}}
<div aria-label="breadcrumb " class="breadcrumb py-1 " style="margin-top: 92px">

    <div class="container">

        <ol class="breadcrumb breadcrumb-nav">

            <li class="breadcrumb-item "><a href="{{route('landing')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Login</li>


        </ol>


    </div>

</div>
{{-- End BreadCrumb --}}
<div id="login-section" class="mb-5">

    <div class="container">
        <div class="card card0 border-0">
            <div class="row d-flex">
                <div class="col-lg-6">
                    <div class="card1 pb-5">
                        <div class="row"> <img src="/storage/images/design/logos/mylogo.png" width="100" height="100"
                                class="logo img-fluid"> </div>
                        <div class="row px-3 justify-content-center mt-4 mb-5 border-line"> <img
                                src="/storage/images/design/random/hero.png" class="image"> </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card2 card border-0 px-4 py-5">
                        <div class="row mb-4 px-3">
                            <h6 class="mb-0 mr-4 mt-2">Sign in with</h6>

                                <a href="/login/facebook" class="btn btn-primary-schema text-white hover-bigger"><i class="fa fa-facebook"></i></a>
    

                        </div>
                        <div class="row px-3 mb-4">
                            <div class="line"></div> <small class="or text-center">Or</small>
                            <div class="line"></div>
                        </div>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf



                            <div class="row px-3"> <label class="mb-1">


                                    <h6 class="mb-0 text-sm">Email Address</h6>
                                </label>
                                <input id="email" type="email" placeholder="Enter a valid email address"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="row px-3"> <label class=" mt-4">


                                    <h6 class="mb-0 text-sm">Password</h6>
                                </label> <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="current-password" placeholder="Enter password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="row px-3 mb-4">
                                <div class="custom-control custom-checkbox custom-control-inline">


                                    <input  type="checkbox"  name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}  class="custom-control-input">
                                    <label for="remember" class="custom-control-label text-sm">Remember me</label>
                                </div>

                                @if (Route::has('password.request'))
                                <a class="ml-auto mb-0 text-sm" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                                @endif
                            </div>
                            <div class="row mb-3 px-3"> <button type="submit"
                                    class="btn btn-blue text-center">Login</button> </div>
                        </form>
                        <div class="row mb-4 px-3"> <small class="font-weight-bold">Don't have an account? <a
                        class="text-danger " href="{{route('register')}}">Register</a></small> </div>
                    </div>
                </div>
            </div>
            <div class="bg-blue py-4">
                <div class="row px-3"> <small class="ml-4 ml-sm-5 mb-2">Copyright &copy; 2019. All rights
                        reserved.</small>
                    <div class="social-contact ml-4 ml-sm-auto"> <span class="fa fa-facebook mr-4 text-sm"></span> <span
                            class="fa fa-google-plus mr-4 text-sm"></span> <span
                            class="fa fa-linkedin mr-4 text-sm"></span> <span
                            class="fa fa-twitter mr-4 mr-sm-5 text-sm"></span> </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
