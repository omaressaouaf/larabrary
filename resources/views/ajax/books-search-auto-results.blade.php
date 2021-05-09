<ul class="list-group searchAutoList">
    @forelse ($books as $book)
    <li class="list-group-item searchAutoItems">
        <div class="row">

            <div class="col-md-2 col-sm-4">
                <img class="" height="95" width="5"
                src="{{$book->images()->count() ? $book->images()->first()->name : '/storage/images/books/noimagebook.svg' }}"
                alt="">
            </div>

            <div class="col-md-6 col-sm-8 searchAutoInfo">

                <h1 class="lead "><a href="{{route('library.show',$book->slug)}}"
                        class="searchAutoTitle">{{$book->title}}</a></h1>
                <p class="lead text-muted">by {{$book->user->name}}</p>
            </div>

        </div>
    </li>

    @empty
    <li class="list-group-item ">

        No books Found

    </li>

    @endforelse
    @if (count($books) && count($books) == 4)
    <a href="" onclick="event.preventDefault();
    document.getElementById('searchAutoForm').submit();" id="viewAllAutoAnker" class="btn btn-info">
        View All
    </a>
    @endif

</ul>