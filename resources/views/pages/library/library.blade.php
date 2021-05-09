@extends('layouts.app')
@section('extra-styles')
<style>

</style>
@endsection
@section('content')


<div aria-label="breadcrumb " class="breadcrumb py-1 " style="margin-top: 92px">

    <div class="container">

        <ol class="breadcrumb">

            <li class="breadcrumb-item"><a href="{{route('landing')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Library</li>

        </ol>


    </div>

</div>


<div class="container ">



    <div class="row">

         @include('includes.library-sidebar')


        <div class="col-lg-9 product-list">
            {{-- <section> --}}
            <div class="container">
                <div class="row mb-4">
                    <div class="col-lg-12">
                        <h1 class="text-center lead display-4 text-capitalize">{{$genreName}} Books</h1>

                        @include('includes.library-search-form')

                    </div>
                </div>

                {{-- Books  --}}
                <div class="row">



                    @forelse ($books as $book)
                    <div class="col-md-4">

                        <div class="pro-img-box">
                            <a href="{{route("library.show",$book->slug)}}">

                                <img class="" width="50" height="280"
                                    src="{{$book->images()->count() ? $book->images()->first()->name : '/storage/images/books/noimagebook.svg' }}"
                                    alt="">

                            </a>
                            <i class="adtocart">

                                <form action="" class="addToCartForm">

                                    <input type="hidden" class="book_id" value="{{$book->id}}">



                                    <button type="" class="px-2 btn btn-default addToCartBtn"><i
                                            class=" fa fa-shopping-cart " data-toggle="tooltip" data-placement="top"
                                            title="Add to Cart"></i>
                                        <span class="cart-item"></span>
                                    </button>




                                </form>


                            </i>
                        </div>

                        <div class="panel-body text-center">
                            <h4>
                                <a href="{{route("library.show",$book->slug)}}" class="pro-title text-info">
                                    <h5>{{ Str::limit($book->title, 30,$end='...') }}</h5>
                                </a>
                            </h4>
                            <p class="price">${{$book->price}}</p>
                        </div>

                    </div>
                    @empty
                    <div class="alert alert-info mx-auto text-center" role="alert">
                        <h3 class="alert-heading"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> No books
                            Found
                            !</h3>
                        <p>Sorry ! No books found

                    </div>
                    @endforelse

                </div>
                {{-- End Books --}}

            </div>
            {{-- <h5 class="lead"> {{ $books->links() }} </h5> --}}
            <h5 class="lead"> {{ $books->appends(request()->input())->links()}} </h5>
            {{-- </section> --}}

        </div>

    </div>

</div>

@endsection
