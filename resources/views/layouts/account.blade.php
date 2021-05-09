@extends('layouts.app')
@section('extra-styles')

<link rel="stylesheet" href="{{asset("css/profile.css")}}">
@yield('account-extra-styles')
@endsection

@section('content')

<div class="container" id="account-box">


    <div class="row">
        <div class="col-lg-3 ">
            @include('includes.account-sidebar')
        </div>
        <div class="col-lg-9 ">
            <div class="container rounded  bg-white  ">
                <div class="row">


                    <div class="col-md-12 bg-white">

                        <div class="p-3 py-5">
                            @yield('account-content')
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('extra-scripts')
@yield('account-extra-scripts')
@endsection

