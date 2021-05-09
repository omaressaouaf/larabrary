@extends('layouts.app')
@section('extra-styles')
<style>


</style>
@endsection
@section('content')

  {{-- Preloader --}}
  <div id="preloder">
    <div class="loader"></div>
  </div>
@include("includes.hero")



@include("includes.landing-summary")

@endsection
