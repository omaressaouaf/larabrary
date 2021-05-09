{{-- <section> --}}
<div class="container">
    <div class="row mb-4">
        <div class="col-lg-12">
            <h1 class="text-center lead display-4">Search Results Books</h1>

            <form action="{{route('library.search')}}" method="GET">
                @include('includes.alerts')
                <div class="input-group ">

                    <input type="text" required name="search_query" id="search_query" placeholder="Search For Any Book"
                        class="form-control">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-primary-schema "> <i class="fa fa-search"></i></button>
                    </span>
                </div>

            </form>

        </div>
    </div>
    <h3 class="lead mb-5 text-center display-5 " id="searchBriefSpn"> <span
            id="resultsCountSpn">{{$books->total()}}</span>
        Result(s) for
        <span id="searchQuerySpn" class="text-info  font-weight-bolder"><strong>
                '{{request()->search_query}}'</strong></span></h3>
    {{-- Books  --}}
    <div class="row">



        @forelse ($books as $book)
        <div class="col-md-4">

            <div class="pro-img-box">
                <a href="{{route("library.show",$book->slug)}}">      <img class="" width="50" height="300"
                    src="{{$book->images()->count() ? $book->images()->first()->name : '/storage/images/books/noimagebook.svg' }}"
                    alt=""></a>
                <i class="adtocart">
                    <form action="" class="addToCartForm">
                        <input type="hidden" class="book_id" value="{{$book->id}}">

                        <button type="" class="px-2 btn btn-default addToCartBtn"><i class=" fa fa-shopping-cart "
                                data-toggle="tooltip" data-placement="top" title="Add to Cart"></i></button>

                    </form>

                </i>
            </div>

            <div class="panel-body text-center">
                <h4>
                    <a href="{{route("library.show",$book->slug)}}" class="pro-title text-info">
                        {{$book->title}}
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
<h5 class="lead" id="resultsPagination"> {{ $books->appends(request()->input())->links()}} </h5>
{{-- </section> --}}