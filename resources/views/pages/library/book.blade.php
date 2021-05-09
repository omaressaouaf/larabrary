@extends('layouts.app')
@section('extra-styles')
<style>

</style>

@endsection
@section('content')
{{-- Breadcrumb --}}
<div aria-label="breadcrumb " class="breadcrumb py-1 " style="margin-top: 92px">

    <div class="container">

        <ol class="breadcrumb">

            <li class="breadcrumb-item "><a href="{{route('landing')}}">Home</a></li>
            <li class="breadcrumb-item "><a href="{{route('library')}}">Library</a> </li>
            <li class="breadcrumb-item active" aria-current="page">{{$book->title}}</li>

        </ol>


    </div>

</div>
{{-- End BreadCrumb --}}



<div class="container" id="">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12">
            <!-- product -->
            <div class="product-content product-wrap clearfix product-deatil">
                <div class="row">
                    <div class="col-md-5 col-sm-12 col-xs-12">
                        <div class="product-image mr-4">
                            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                    @for ($i = 1; $i < $book->images->count(); $i++)
                                        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                        @endfor

                                </ol>
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img class="d-block w-100"
                                            src="{{$book->images()->count() ? $book->images()->first()->name : '/storage/images/books/noimagebook.svg' }}"
                                            alt="First slide">
                                    </div>
                                    @for ($i = 1; $i < $book->images->count(); $i++)

                                        <div class="carousel-item">
                                            <img class="d-block w-100" src="{{$book->images[$i]->name}}"
                                                alt="Second slide">
                                        </div>
                                        @endfor

                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button"
                                    data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button"
                                    data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                            {{-- <img class="img-fluid" alt=""
                                src="https://99designs-start-attachments.imgix.net/alchemy-pictures/2016%2F02%2F12%2F00%2F05%2F05%2F910db405-6bd4-4a5d-bce7-c2e3135dc5e6%2F449070_WAntoneta_55908c_killing.png?auto=format&ch=Width%2CDPR&fm=png&w=600&h=600" /> --}}
                        </div>
                    </div>

                    <div class="col-md-6 col-md-offset-1 col-sm-12 col-xs-12">
                        <h2 class="name">
                            {{$book->title}}
                            <small class="mt-3 mb-2">Book by <a
                                    href="javascript:void(0);">{{$book->user->name}}</a></small>
                            <star-rating :show-rating="false" :star-size="20" :read-only="true"
                                :rating="{{$book->calculateStarRating()}}">
                            </star-rating>
                            <span class="fa fa-2x ml-1">
                                <h5>
                                    {{$book->reviews()->count()}} review(s)
                                </h5>
                            </span>
                        </h2>
                        <hr />
                        <h3 class="price-container">
                            ${{$book->price}}
                            <small>excludes taxes</small>
                        </h3>
                        <div class="certified">
                            <ul>
                                <li>
                                    <a href="javascript:void(0);">Delivery time<span>7 Working Days</span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);">Certified<span>Quality Assured</span></a>
                                </li>
                            </ul>
                        </div>
                        <h3 class="price-container">
                            Genres :
                            <span class=" text-muted text-capitalize text-sm">
                                @php
                                $counter =0;
                                @endphp

                                @foreach ($book->genres as $genre)

                                @php
                                $counter ++;
                                @endphp

                                <a href="{{route('library',['genre'=>$genre->slug])}}"> {{$genre->name}} </a>
                                @if ($counter < count($book->genres))
                                    /
                                    @endif
                                    @endforeach
                            </span>

                        </h3>
                        <br>
                        <h3 class="price-container">Availability:
                            <span class="{{$book->stock >5 ? 'text-success' :'text-danger'}}">
                                @if ($book->stock >5)
                                In Stock
                                @elseif($book->stock <5 && $book->stock >0)
                                    Out of Stock ! Hurry
                                    @else
                                    Not Available
                                    @endif
                            </span>
                        </h3>

                        <hr>
                        <div class="description description-tabs">
                            <nav>
                                <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab"
                                        href="#nav-desc" role="tab" aria-controls="nav-home" aria-selected="true">Book
                                        Description</a>
                                    <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab"
                                        href="#nav-review" role="tab" aria-controls="nav-home"
                                        aria-selected="false">Book Reviews</a>

                                </div>
                            </nav>
                            <div id="myTabContent" class="tab-content">
                                <div class="tab-pane fade show active" id="nav-desc" role="tabpanel"
                                    aria-labelledby="nav-home-tab">
                                    <br />

                                    <p>
                                        {{$book->description}}
                                    </p>
                                </div>

                                <reviews :book="{{$book}}"></reviews>
                            </div>
                        </div>
                        <hr />
                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                @if ($book->stock > 0 )


                                <form action="{{route('cart.store')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$book->id}}">
                                    <input type="hidden" name="title" value="{{$book->title}}">
                                    <input type="hidden" name="price" value="{{$book->price}}">

                                    <button class="btn btn-success " type="submit"><i class="fa fa-cart-plus"></i> Add
                                        to
                                        cart</button>


                                </form>


                                @endif
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-6">
                                <div class="btn-group pull-right">
                                    <form action="{{route('wishlist.store')}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$book->id}}">
                                        <input type="hidden" name="title" value="{{$book->title}}">
                                        <input type="hidden" name="price" value="{{$book->price}}">
                                        <button class="btn btn-danger " type="submit"><span class="fa fa-heart"></span>
                                            Add
                                            to Wishlist</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end product -->
        </div>
    </div>
</div>





{{--  might like section --}}
@include('includes.might-like')
@endsection
@section('extra-scripts')
<script>
    $(document).ready(function(){

    })
</script>
@endsection
