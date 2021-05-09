<div class="booksDemo mt-5 mb-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2 class="booksDemoTitle">Best Selling <b>Books</b></h2>
                <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="0">
                    <!-- Carousel indicators -->
                    <ol class="carousel-indicators">
                        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                        <li data-target="#myCarousel" data-slide-to="1"></li>
                    </ol>
                    <!-- Wrapper for carousel items -->
                    <div class="carousel-inner">



                        <div class="carousel-item active">
                            <div class="row">

                                @for ($i = 0; $i < $bestSellingBooks->count() -4 ; $i++)

                                    <div class="col-sm-3">
                                        <div class="thumb-wrapper">
                                            <div class="img-box">
                                                <img class="img-fluid"
                                                    src="{{$bestSellingBooks[$i]->imagePath ? $bestSellingBooks[$i]->imagePath : '/storage/images/books/noimagebook.svg' }}"
                                                    alt="">
                                            </div>
                                            <div class="thumb-content">
                                                <h4><a
                                                        href="{{route('library.show',$bestSellingBooks[$i]->slug)}}">{{ Str::limit($bestSellingBooks[$i]->title, 30,$end='...')}}</a>
                                                </h4>
                                                <p class="item-price"><strike>$10.00</strike>
                                                    <span>${{$bestSellingBooks[$i]->price}}</span></p>
                                                <div class="star-rating ">
                                                    <ul class="list-inline">
                                                        <li class="list-inline-item">
                                                            <star-rating :glow="10" :border-width="1"
                                                                :rounded-corners="true" :show-rating="false"
                                                                :star-size="15" :read-only="true"
                                                                :rating="{{$bestSellingBooks[$i]->starRating}}">
                                                        </li>

                                                    </ul>

                                                </div>
                                                <a href="{{route('library.show',$bestSellingBooks[$i]->slug)}}"
                                                    class="btn btn-primary">View Details</a>
                                            </div>
                                        </div>
                                    </div>
                                    @endfor
                            </div>
                        </div>
                        <div class="carousel-item ">
                            <div class="row">

                                @for ($i = 4; $i < $bestSellingBooks->count() ; $i++)

                                    <div class="col-sm-3">
                                        <div class="thumb-wrapper">
                                            <div class="img-box">
                                                <img class="img-fluid"
                                                    src="{{$bestSellingBooks[$i]->imagePath ? $bestSellingBooks[$i]->imagePath : '/storage/images/books/noimagebook.svg' }}"
                                                    alt="">
                                            </div>
                                            <div class="thumb-content">
                                                <h4><a
                                                        href="{{route('library.show',$bestSellingBooks[$i]->slug)}}">{{ Str::limit($bestSellingBooks[$i]->title, 100,$end='...')}}</a>
                                                </h4>
                                                <p class="item-price"><strike>$10.00</strike>
                                                    <span>${{$bestSellingBooks[$i]->price}}</span></p>
                                                <div class="star-rating">
                                                    <ul class="list-inline">
                                                        <li class="list-inline-item">
                                                            <star-rating :glow="10" :border-width="1"
                                                                :rounded-corners="true" :show-rating="false"
                                                                :star-size="15" :read-only="true"
                                                                :rating="{{$bestSellingBooks[$i]->starRating}}">
                                                        </li>
                                                    </ul>
                                                </div>
                                                <a href="{{route('library.show',$bestSellingBooks[$i]->slug)}}"
                                                    class="btn btn-primary">View Details</a>
                                            </div>
                                        </div>
                                    </div>
                                    @endfor
                            </div>
                        </div>

                    </div>
                    <!-- Carousel controls -->
                    <a class="carousel-control-prev" href="#myCarousel" data-slide="prev">
                        <i class="fa fa-angle-left"></i>
                    </a>
                    <a class="carousel-control-next" href="#myCarousel" data-slide="next">
                        <i class="fa fa-angle-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
<div class=" mt-5" id="might-like-section">
    <div class="text-center">
        <h2 class="booksDemoTitle">Some Of our <b>Authors</b></h2>
        <h3 class="lead mb-4 ">Lorem ipsum dolor sit amet consectetur.</h3>
    </div>
    <div class="row">
        @foreach ($someAuthors as $author)

        <div class="col-lg-4">
            <div class="team-member">
                <img class="mx-auto rounded-circle" src="{{$author->avatar}}" alt="" />
                <a href="/" class="">
                    <h4 class="mb-3">{{$author->name}}</h4>
                </a>
                <p class="text-muted">Joined us {{$author->created_at->diffForHumans()}}</p>
                <a class="btn btn-info btn-social mx-2" href="#!"><i class=" fa fa-twitter"></i></a>
                <a class="btn btn-primary-schema btn-social mx-2" href="#!"><i class="fa fa-facebook-f"></i></a>
                <a class="btn btn-danger btn-social mx-2" href="#!"><i class="fa fa-youtube"></i></a>
            </div>
        </div>
        @endforeach
    </div>
    <div class="row">
        <div class="col-lg-8 mx-auto text-center">
            <p class="large text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut eaque,
                laboriosam veritatis, quos non quis ad perspiciatis, totam corporis ea, alias ut unde.</p>
        </div>
    </div>
</div>
