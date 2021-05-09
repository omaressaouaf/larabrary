<section id="might-like-section">
  <div class="container text-center">
    <h3 class="lead display-4 text-center ">You might also like ... </h3>

    <div class="col-lg-12 product-list mt-5">

      <div class="container ">
        {{-- Might Like Books --}}
        <div class="row">
          @foreach ($mightLike as $book )

          <div class="col-sm-3">
            <div class="thumb-wrapper">
              <div class="img-box">
                <img class="" width="50" height="300"
                  src="{{$book->images()->count() ? $book->images()->first()->name : '/storage/images/books/noimagebook.svg' }}"
                  alt="">
              </div>
              <div class="thumb-content mt-3">
                <h4><a href="{{route('library.show',$book->slug)}}">{{ Str::limit($book->title, 30,$end='...')}}</a>
                </h4>
                <p class="item-price"><strike>$10.00</strike>
                  <span>${{$book->price}}</span></p>
                <div class="star-rating">
                  <ul class="list-inline">
                    <li class="list-inline-item">
                      <star-rating :glow="10" :border-width="1" :rounded-corners="true" :show-rating="false"
                        :star-size="15" :read-only="true" :rating="{{$book->calculateStarRating()}}">
                    </li>
                  </ul>
                </div>
                <a href="{{route('library.show',$book->slug)}}" class="btn btn-primary">View Details</a>
              </div>
            </div>
          </div>

          @endforeach
        </div>
        {{-- End Might Like Books --}}
      </div>

    </div>
  </div>


</section>