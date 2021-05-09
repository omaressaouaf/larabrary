@extends('layouts.account')
@section('account-extra-styles')
<style>
    body {
        min-height: 100vh;
        background-size: cover;
        font-family: 'Lato', sans-serif;
        color: #042D57;

    }


    p {
        font-size: 14px !important;
        margin-bottom: 7px !important
    }

    .small {
        letter-spacing: 0.5px !important
    }

    .card-1 {
        transition: 0.19s;
    }

    .card-1:hover {
        box-shadow: 2px 2px 10px 0px #042D57 !important
    }

    hr {
        background-color: rgba(248, 248, 248, 0.667) !important
    }

    .bold {
        font-weight: 500 !important
    }

    .change-color {
        color: #042D57 !important
    }

    .card-2 {
        box-shadow: 1px 1px 3px 0px rgb(112, 115, 139) !important
    }

    .fa-circle.active {
        font-size: 8px !important;
        color: #042D57 !important
    }

    .fa-circle {
        font-size: 8px !important;
        color: #aaa !important
    }

    .rounded {
        border-radius: 2.25rem !important
    }

    .progress-bar {
        background-color: #042D57 !important
    }

    .progress {
        height: 5px !important;
        margin-bottom: 0 !important
    }

    .invoice {
        position: relative !important;
        top: -108px
    }

    .Glasses {
        position: relative !important;
        top: -12px !important
    }

    .card-footer {
        background-color: #042D57 !important;
        color: #fff !important
    }

    h2 {
        color: rgb(129, 4, 151) !important;
        letter-spacing: 2px !important
    }

    h4 {
        font-family: sans-serif !important;
        font-weight: 20 !important;


    }

    .display-3 {
        font-weight: 500 !important
    }

    @media (max-width: 479px) {
        .invoice {
            position: relative;
            top: 7px
        }

        .border-line {
            border-right: 0px solid rgb(226, 206, 226) !important
        }
    }

    @media (max-width: 700px) {
        h2 {
            color: rgb(124, 7, 145) !important;
            font-size: 17px !important
        }

        .display-3 {
            font-size: 28px !important;
            font-weight: 500 !important
        }
    }

    .card-footer small {
        letter-spacing: 7px !important;
        font-size: 12px
    }

    .border-line {
        border-right: 1px solid rgb(226, 206, 226)
    }
</style>
@endsection


@section('account-content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <div class="d-flex flex-row align-items-center back">
        <a href="{{route('user.dashboard')}}" class="btn btn-info">
            <i class="fa fa-chevron-left mr-1 mb-1"></i> Back to Dashboard
        </a>
    </div>
    <h6 class="text-right lead display-4 text-success">Your Order details</h6>
</div>


<div class="container-fluid my-5 d-flex justify-content-center ">
    <div class="card card-1 ">
        <div class="card-header bg-white">
            <div class="media flex-sm-row flex-column-reverse justify-content-between ">
                <div class="col my-auto">

                    <h4> <a href="{{url()->previous()}}"><i class="fa fa-arrow-left"></i></a> Thank you for your Order
                    </h4>

                </div>
                <div class="col-auto text-center my-auto pl-0 pt-sm-4 "> <img
                        class="img-fluid my-auto  align-items-center mb-0 pt-3"
                        src="{{asset('storage/images/design/logos/mylogo.png')}}" width="115" height="115">

                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row justify-content-between mb-3">
                <div class="col-auto">
                    <h6 class="color-1 mb-0 change-color">Books in your order</h6>
                </div>
                <div class="col-auto "> <small>Receipt Voucher : 1KAU9-84UIL</small> </div>
            </div>
            @foreach ($userOrderDetails as $book)

            <div class="row mb-3">
                <div class="col">
                    <div class="card card-2">
                        <div class="card-body">
                            <div class="media">
                                <div class="sq align-self-center "> <img
                                        class="img-fluid my-auto align-self-center mr-2 mr-md-4 pl-0 p-0 m-0"
                                        src="{{ ($book->id && $book->images->count()) ? $book->images()->first()->name : '/storage/images/books/noimagebook.svg' }}"
                                        width="135" height="135" /> </div>
                                <div class="media-body my-auto text-right">
                                    <div class="row my-auto flex-column flex-md-row">
                                        <div class="col my-auto">
                                            <h6 class="mb-0 float-left">
                                                <a href="{{$book->id ? route('library.show',$book->slug) : '#'}}">{{ Str::limit($book->title, 30,$end='...')
                                            }} </a>
                                            </h6>
                                        </div>

                                        <div class="col-auto my-auto"> <small>by
                                                {{$book->user->name }} </small></div>

                                        <div class="col my-auto"> <small>Qty :
                                                {{  $book->pivot->quantity }}</small>
                                        </div>
                                        <div class="col my-auto">
                                            <h6 class="mb-0">
                                                ${{ $book->pivot->book_subtotal}}
                                            </h6>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <hr class="my-3 ">
                            <div class="row">
                                <div class="col-md-3 mb-3"> <small> Track Order <span><i class=" ml-2 fa fa-refresh"
                                                aria-hidden="true"></i></span></small> </div>
                                <div class="col mt-auto">
                                    <div class="progress my-auto">
                                        <div class="progress-bar progress-bar rounded" style="width: 62%"
                                            role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            @endforeach

            <div class="row mt-4">
                <div class="col-md-7">

                    <p class="mb-1 text-success"><b>Order Details </b></p>
                    <p class="mb-1"><b> Billing Email </b>: {{$userOrder->billing_email}}</p>
                    <p class="mb-1"><b> Billing Full name </b>: {{$userOrder->billing_full_name}}</p>
                    <p class="mb-1"><b> Billing Phone Number </b>: {{$userOrder->billing_phone}}</p>
                    <p class="mb-1"><b> Billing Address </b>: {{$userOrder->billing_country}}
                        ,{{$userOrder->billing_state}},{{$userOrder->billing_city}} <br>{{ $userOrder->billing_address}}
                        , ZIP : {{$userOrder->billing_zip}}
                    </p>


                </div>

                <div class="col md-5">

                    <div class="row justify-content-between ">

                        <div class="flex-sm-col text-right col ">
                            <p class="mb-1 text-success"><b>Payment</b></p>
                        </div>

                    </div>
                    <div class="row justify-content-between ">

                        <div class="flex-sm-col text-right col ">
                            <p class="mb-1"><b>Total</b></p>
                        </div>
                        <div class="flex-sm-col col-auto">
                            <p class="mb-1">${{$userOrder->billing_total}}</p>
                        </div>
                    </div>
                    <div class="row justify-content-between">
                        <div class="flex-sm-col text-right col">
                            <p class="mb-1"> <b>Discount</b></p>
                        </div>
                        <div class="flex-sm-col col-auto">
                            <p class="mb-1">${{$userOrder->billing_discount}}</p>
                        </div>
                    </div>
                    <div class="row justify-content-between">
                        <div class="flex-sm-col text-right col">
                            <p class="mb-1"><b>GST 38%</b></p>
                        </div>
                        <div class="flex-sm-col col-auto">
                            <p class="mb-1">${{$userOrder->billing_tax}}</p>
                        </div>
                    </div>
                    <div class="row justify-content-between">
                        <div class="flex-sm-col text-right col">
                            <p class="mb-1"><b>Delivery Charges</b></p>
                        </div>
                        <div class="flex-sm-col col-auto">
                            <p class="mb-1">Free</p>
                        </div>
                    </div>
                    <div class="row justify-content-between">
                        <div class="flex-sm-col text-right col">
                            <p class="mb-1"><b>Payment Method</b></p>
                        </div>
                        <div class="flex-sm-col col-auto">
                            <p class="mb-1">
                                {{($userOrder->payment_mode == 'cash')?  'Cash on delivery' : 'Credit / Debit Card'}}
                            </p>
                        </div>
                    </div>
                    @if ($userOrder->payment_mode == "stripe")
                    <div class="row justify-content-between">
                        <div class="flex-sm-col text-right col">
                            <p class="mb-1"><b>Card Holder Name</b></p>
                        </div>
                        <div class="flex-sm-col col-auto">
                            <p class="mb-1">{{$userOrder->billing_card_holder_name}}</p>
                        </div>
                    </div>
                    @endif
                </div>

            </div>



        </div>
        <div class="card-footer">
            <div class="jumbotron-fluid">
                <div class="row justify-content-between ">
                    <div class="col-sm-auto col-auto my-auto"><img class="img-fluid my-auto align-self-center "
                            src="{{asset('storage/images/design/logos/mylogo.png')}}" width="115" height="115"></div>
                    <div class="col-auto my-auto ">
                        <h2 class="mb-0 font-weight-bold text-primary">TOTAL PAID</h2>
                    </div>
                    <div class="col-auto my-auto ml-auto">
                        <h1 class="display-3 ">${{$userOrder->billing_total}}</h1>
                    </div>
                </div>

                <div class="row mb-3 mt-3 mt-md-0">
                    <div class="col-auto border-line"> <small class="text-white">PAN:AA02hDW7E</small></div>
                    <div class="col-auto border-line"> <small class="text-white">CIN:UMMC20PTC </small></div>
                    <div class="col-auto "><small class="text-white">GSTN:268FD07EXX </small> </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
