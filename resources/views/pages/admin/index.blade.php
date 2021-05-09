@extends('layouts.admin.admin-app')
@section('content')


@auth

<app csrf={{ csrf_token() }}></app>
@endauth







@endsection