@extends('layouts.app')
@section('content')
<section>

    <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-10 col-sm-12 text-center">
            <h1 class="display-3 mb-4">You seem Lost ?</h1>
            <img src="/storage/images/design/random/404.svg" alt />
            <a href="{{route('landing')}}" class="btn btn-primary-schema btn-block btn-lg mb-4">Go Home Instead</a>
          </div>
        </div>
      </div>
</section>
@endsection