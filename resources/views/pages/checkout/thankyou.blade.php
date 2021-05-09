@extends('layouts.app')

@section('content')
<section class="page-section mt-4">
    <div class="container">
        <div class="jumbotron text-center">
            <h1 class="display-3 text-success">Thank You!</h1>
            <p class="lead">Please check your email for your order<strong> Confirmation.</strong></p>
            <hr>
            <p>
              Having trouble? <a href="" class="text-info">Contact us</a>
            </p>
            <p class="lead">
              <a class="btn btn-primary " href="{{route('landing')}}" role="button">Continue to homepage</a>
            </p>
          </div>
    </div>
</section>

@endsection