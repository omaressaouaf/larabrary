@extends('layouts.app')
@section('extra-styles')
<style>

</style>
@endsection
@section('content')
<div aria-label="breadcrumb " class="breadcrumb py-1 " style="margin-top: 92px">

    <div class="container">

        <ol class="breadcrumb breadcrumb-nav">

            <li class="breadcrumb-item "><a href="{{route('landing')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"> Our Authors</li>


        </ol>


    </div>

</div>
<div class="container">
    <div class="main-body">


        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-xl-4 gutters-sm">
            @foreach ($authors as $author)
            <div class="col mb-3">
                <div class="card">
                    <img src="/storage/images/design/random/dashboard-bg.jpg" alt="Cover" class="card-img-top">
                    
                    <div class="card-body text-center">
                        <img src="{{$author->avatar}}" style="width:100px;margin-top:-65px" alt="User"
                            class="img-fluid img-thumbnail rounded-circle border-0 mb-3">
                        <a href="{{route('authors.show',$author->id)}}">
                            <h5 class="card-title">{{$author->name}}</h5>
                        </a>
                        <p class="text-secondary mb-1"><span class="text-success lead">Joind us on
                                :</span>{{Carbon\Carbon::parse($author->created_at)->format(' d M  Y')}}</p>
                        <p class="text-muted font-size-sm">{{$author->country}} / {{$author->city}} </p>
                    </div>
                    <div class="card-footer">
                        <a href="{{route('authors.show',$author->id)}}" class="btn btn-info btn-block">View Work</a>
                    </div>
                </div>
            </div>
            @endforeach

            

        </div>
        

            {{$authors->links()}}
        
    </div>
</div>



@endsection