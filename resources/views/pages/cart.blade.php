@extends('layouts.app')

@section('content')
{{-- Breadcrumb --}}



<div aria-label="breadcrumb " class="breadcrumb py-1 " style="margin-top: 92px">

    <div class="container">
        <ol class="breadcrumb">



            <li class="breadcrumb-item "><a href="{{route('landing')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"> Cart </li>
        </ol>
    </div>

</div>

{{-- End BreadCrumb --}}
<div class="container mt-5 mb-5">


    {{-- Alerts --}}
    @include('includes.alerts')
    {{-- End Alerts --}}


    <div class="row">


        <div class="col-lg-8">


            <div class="card wish-list mb-3">
                {{-- <div class="card-header">

                </div> --}}
                <div class="card-header s ">

                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                    My Cart

                    <a href="{{route('library')}}" class="btn btn-success btn-sm pull-right">Continue Shopping</a>
                    <div class="clearfix"></div>
                </div>
                <div class="card-body">




                    <h5 class="mb-4 text-center">Cart ( <span>{{Cart::instance('default')->count()}}</span> item(s)
                        )</h5>

                    @if (Cart::instance('default')->count() >0)
                    {{-- Cart Items --}}
                    @foreach (Cart::instance('default')->content() as $item)
                    <div class="row mb-4">
                        <div class="col-md-5 col-lg-3 col-xl-3">
                            <div class="view zoom overlay z-depth-1 rounded mb-3 mb-md-0">

                                <a href="{{route('library.show',$item->model->slug)}}">
                                    <img class="img-fluid"
                                    src="{{$item->model->images()->count() ? $item->model->images()->first()->name : '/storage/images/books/noimagebook.svg' }}"
                                    alt="">
                                </a>
                            </div>
                        </div>
                        <div class="col-md-7 col-lg-9 col-xl-9">
                            <div>
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <a href="{{route('library.show',$item->model->slug)}}">
                                            <h5>{{ Str::limit($item->model->title, 30,$end='...') }}</h5>
                                        </a>
                                        <span class="lead">Brief Description : </span> <br>
                                        <span class="text-muted">
                                            {!! Str::limit($item->model->description, 100,$end='...') !!}
                                        </span>
                                        <p class="mb-0"><span>Item Price
                                                :<strong>${{$item->model->price}}</strong></span></p>


                                    </div>
                                    <div>
                                        <div class="def-number-input number-input safari_only mb-0 w-100">

                                            <select name="quantity" id="quantity" data-id="{{$item->rowId}}"
                                                class="quantity form-control">
                                                @for ($i = 1; $i <= $item->model->stock  ; $i++)
                                                    <option value="{{$i}}" {{$item->qty==$i ? 'selected' : ''}}>{{$i}}
                                                    </option>


                                                    @endfor


                                            </select>

                                        </div>
                                        <small id="passwordHelpBlock" class="form-text text-muted text-center">
                                            (Note, Quantity)

                                        </small>

                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <form class="form-inline mt-4"
                                                action="{{route('cart.destroy',$item->rowId)}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class=" btn btn-outline-danger btn-sm text-uppercase mr-3">
                                                    <i class="fa fa-trash mr-1"></i> Remove Book
                                                </button>
                                            </form>
                                        </div>
                                        <div class="col-md-5">
                                            <form class="form-inline mt-4"
                                                action="{{route('cart.moveToWishlist',$item->rowId)}}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class=" btn btn-outline-info btn-sm text-uppercase mr-3">
                                                    <i class="fa fa-arrow-down mr-1"></i> Move to Wishlist
                                                </button>
                                            </form>

                                        </div>
                                        <div class="col-md-3">
                                            <p class="mb-0 mr-5"><span>Item
                                                    Subtotal<strong>${{$item->subtotal()}}</strong></span></p>
                                        </div>




                                    </div>


                                </div>

                            </div>
                        </div>
                    </div>
                    <hr class="mb-4">
                    @endforeach
                    {{-- End Cart Items --}}
                    <a href="{{route('cart.empty')}}" class="btn btn-danger ml-2 btn-sm pull-right">Clear Cart </a>
                    <p class="text-info mb-0 "><i class="fa fa-info-circle mr-1"></i> Do not delay the purchase,
                        adding
                        items to your cart does not mean booking them. they could be removed from your cart due to an
                        instance unavailability.</p>
                    @else
                    <div class="alert alert-info" role="alert">
                        <h3 class="alert-heading"><i class="fa fa-frown-o" aria-hidden="true"></i> Cart is Empty
                            !</h3>
                        <p>Opps It Looks like You have No Books In your Carts Yet ! You will Enjoy Our Books if
                            You take A look at <a href="{{route('library')}}"><strong>The
                                    Library</strong></a>.</p>

                    </div>

                    @endif
                    @guest
                    <div class="alert alert-info mt-3" role="alert">
                        <h6 class="text-dark  lead"><i class="fa fa-exclamation-circle"></i> Do you already have an
                            account ? <strong><a href="{{route('login')}}">Login</a></strong> in order to see your cart
                            items</h6>
                    </div>


                    @endguest

                </div>
            </div>


            {{-- Shipping delivery --}}
            @if (Cart::instance('default')->count()>0)
            <div class="card mb-3">
                <div class="card-body">

                    <h5 class="mb-4">Expected shipping delivery</h5>

                    <p class="mb-0"> Thu., 12.03. - Mon., 16.03.</p>
                </div>
            </div>
            @endif
            {{-- End Shipping Delivery --}}


            {{-- We Accept  --}}
            <div class="card mb-3">
                <div class="card-body">

                    <h5 class="mb-4">We accept</h5>

                    <img class="mr-2" width="45px"
                        src="https://mdbootstrap.com/wp-content/plugins/woocommerce-gateway-stripe/assets/images/visa.svg"
                        alt="Visa">
                    <img class="mr-2" width="45px"
                        src="https://mdbootstrap.com/wp-content/plugins/woocommerce-gateway-stripe/assets/images/amex.svg"
                        alt="American Express">
                    <img class="mr-2" width="45px"
                        src="https://mdbootstrap.com/wp-content/plugins/woocommerce-gateway-stripe/assets/images/mastercard.svg"
                        alt="Mastercard">

                </div>
            </div>
            {{-- End we Accept --}}


        </div>



        <div class="col-lg-4">

            {{-- Cart Total Amount --}}
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="mb-3 text-center">Total Price Details</h5>
                </div>
                <div class="card-body">



                    <ul class="list-group list-group-flush">
                        <li
                            class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
                            Subtotal
                            <span>${{Cart::subtotal()}}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            Shipping
                            <span class="text-success">Free <i class=" fa fa-smile-o"></i></span>
                        </li>
                        <li
                            class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
                            Tax Rate
                            <span>38 %</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            Tax Amount
                            <span>${{Cart::tax()}}</span>
                        </li>

                        <li
                            class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
                            <div>
                                <strong>The total amount of</strong>
                                <strong>
                                    <p class="mb-0">(including VAT)</p>
                                </strong>
                            </div>
                            <span><strong>${{Cart::total()}}</strong></span>
                        </li>
                    </ul>
                    @if (Cart::instance('default')->count()>0)
                    <a href="{{route('checkout')}}" class="btn btn-info btn-block waves-effect waves-light">Go To
                        Checkout</a>
                    @endif


                </div>
            </div>
            {{-- End Cart Total Amount --}}

        </div>



    </div>
    {{-- Wishlist Container --}}
    <div class="container mt-5">
        <h1 class="text-center display-4 mb-5"><i class="fa fa-heart text-danger"></i> Wishlist Books</h1>
        {{-- Cart Items --}}
        @if (Cart::instance('wishlist')->count() > 0)
        @foreach (Cart::instance('wishlist')->content() as $item)
        <div class="row mb-4">
            <div class="col-md-5 col-lg-3 col-xl-3">
                <div class="view zoom overlay z-depth-1 rounded mb-3 mb-md-0">
                    <a href="{{route('library.show',$item->model->slug)}}">
                        <img class="img-fluid"
                                    src="{{$item->model->images()->count() ? $item->model->images()->first()->name : '/storage/images/books/noimagebook.svg' }}"
                                    alt="">
                    </a>
                </div>
            </div>
            <div class="col-md-7 col-lg-9 col-xl-9">
                <div>
                    <div class=" justify-content-between">
                        <div>
                            <a href="{{route('library.show',$item->model->slug)}}">
                                <h5>{{$item->model->title}}</h5>
                            </a>
                            <span class="lead">Brief Description : </span> <br>
                            <span class="text-muted">
                                {!! Str::limit($item->model->description, 100,$end='...') !!}
                            </span>
                            <p class="mb-0"><span><strong>${{$item->model->price}}</strong></span></p>
                        </div>

                    </div>
                    <div class=" justify-content-between align-items-center">
                        <div class="row">
                            <div class="col-md-6">
                                <form class="form-inline mt-4" action="{{route('wishlist.destroy',$item->rowId)}}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class=" btn btn-outline-danger btn-sm text-uppercase mr-3">
                                        <i class="fa fa-trash mr-1"></i> Remove Book From Wishlist
                                    </button>
                                </form>
                            </div>
                            @if ($item->model->stock >5)
                            <div class="col-md-6">
                                <form class="form-inline mt-4" action="{{route('wishlist.moveToCart',$item->rowId)}}"
                                    method="POST">
                                    @csrf
                                    <button type="submit" class=" btn btn-outline-info btn-sm text-uppercase mr-3">
                                        <i class="fa fa-arrow-up mr-1"></i> Move to Cart
                                    </button>
                                </form>
                            </div>
                            @endif




                        </div>

                    </div>
                </div>
            </div>
        </div>

        <hr class="mb-4">
        @endforeach
        <div class="row ">
            <div class="col-md-7">
                <a href="{{route('wishlist.empty')}}" class="btn btn-danger btn-sm float-right">Clear Wishlist </a>
            </div>

        </div>

        @else
        <div class="alert alert-warning" role="alert">
            <h3 class="alert-heading"><i class="fa fa-frown-o" aria-hidden="true"></i> Wishlist is Empty
                !</h3>
            <p>You have no books saved for later . Take a look at the <a href="{{route('library')}}"><strong>The
                        Library</strong></a>.</p>

        </div>
        @endif
        {{-- End Cart Items --}}

    </div>
    {{-- End Wishlist Container --}}







</div>

@endsection


@section('extra-scripts')
<script>





</script>


@endsection
