<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>


  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">



  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
  @yield('extra-styles')

  {{-- App Logo --}}
  {{-- <link rel="shortcut icon" href="{{ asset('storage/images/design/logos/mylogo.jpg') }}"> --}}


</head>

<body id="page-top">

  {{-- Preloader --}}
  {{-- <div id="preloder">
    <div class="loader"></div>
  </div> --}}
  <div id="app">

    {{-- Navbar --}}
    @include('includes.navbar')


    {{-- content section  --}}
    @yield('content')



    <!-- footer section -->
    @include("includes.footer")




  </div>
  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

  <script>
    $(document).ready( function(){
        //removing the hash in the url from facebook
  if (window.location.hash && window.location.hash == '#_=_') {
    window.location.hash = ''; // for older browsers, leaves a # behind
    history.pushState('', document.title, window.location.pathname); // nice and clean

  }
})
  </script>
  {{-- extra scripts section --}}
  @yield('extra-scripts')

</body>




</html>
