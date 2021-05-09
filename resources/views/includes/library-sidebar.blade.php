<div class="col-lg-3">
    {{-- <section class="panel mt-5 "> --}}

    <div class="mb-4">


        <h1><span class="badge badge-primary bg-info text-uppercase  ">Filters</span></h1>

        <div class="single category mt-4">
            <h3 class="side-title">Genres</h3>
            <ul class="list-unstyled">
                @foreach ($genres as $genre)
                <li class=""><a class="{{ request()->genre ==$genre->slug ? 'active': ''  }}"
                        href="{{route('library',['genre'=>$genre->slug])}}" title="">{{$genre->name}}
                        <span class="pull-right ">{{$genre->books()->count()}}</span></a></li>
                @endforeach


            </ul>
        </div>

    </div>
    @if (Route::current()->getName() == 'library.search')
    @include('includes.library-instant-search')
    @endif

    <div class="mb-4 single ">
        <header class="panel-heading ">
            <h3 class="side-title mb-4">Price</h3>
            <ul class="list-unstyled text-center">
                <a href="{{route('library')}}">Remove Sorting</a>
                <li class="text-center"><a href="{{route('library',['genre'=>request()->genre,'price'=>'low_high'])}} "
                        class="{{ request()->price =="low_high" ? 'active': ''  }} mt-3" title="">low
                        to high </a></li>
                <li class="text-center"><a href="{{route('library',['genre'=>request()->genre,'price'=>'high_low'])}}"
                        class="{{ request()->price =="high_low" ? 'active': ''  }}" title="">high to low </a>
                </li>

            </ul>
        </header>
        <div class="panel-body sliders">
            <div id="slider-range" class="slider"></div>
            <div class="slider-info">
                <span id="slider-range-amount"></span>
            </div>
        </div>
    </div>
    

    <div class="mb-4 single">

        <header class="panel-heading ">
            <h3 class="side-title">Best selling Books</h3>
        </header>
        <div class="panel-body">
            <div class="best-seller mt-4">
                @foreach ($bestSellingBooks as $bestBook)
                <article class="media">
                    <a class="pull-left mr-2 thumb p-thumb" href="{{route('library.show',$bestBook->slug)}}">
                        <img class="img-fluid" height="80" width="80"
                            src="{{$bestBook->imagePath ? $bestBook->imagePath : '/storage/images/books/noimagebook.svg' }}">
                    </a>
                    <div class="media-body">
                        <a href="{{route('library.show',$bestBook->slug)}}" class=" p-head">{{$bestBook->title}}</a>
                        <p>by {{$bestBook->authorname}}</p>
                        <span class="badge badge-success">{{$bestBook->total}} Sold Already</span>
                    </div>
                </article>
                @endforeach


            </div>
        </div>
    </div>
    
    {{-- </section> --}}
</div>