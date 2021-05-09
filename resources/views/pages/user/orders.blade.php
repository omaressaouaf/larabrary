@extends('layouts.account')



@section('account-content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <div class="d-flex flex-row align-items-center back">
        <a href="{{route('user.dashboard')}}" class="btn btn-info">
            <i class="fa fa-chevron-left mr-1 mb-1"></i> Back to Dashboard
        </a>
    </div>
    <h6 class="text-right lead display-4 text-success">Your Orders</h6>
</div>

@forelse ($userOrders as $order)
<div class="card p-3 mb-4">
    <div class="row">
        <div class="col-md-4 col-sm-4">
            <img style="width: 100%"
                src="{{($order->detailsWithRemovedBooks()->first()->id && $order->books()->first()->images()->count()) ? $order->detailsWithRemovedBooks()->first()->images()->first()->name : '/storage/images/books/noimagebook.svg' }}"
                alt="Order Items Image">




        </div>
        <div class="col-md-6 col-sm-8">
            <h3>
                <h1 class="lead ">
                    {{$order->detailsWithRemovedBooks()->first()->id  ? $order->detailsWithRemovedBooks()->first()->title : 'See details ...'}}
                    ....</h1>
                <p class="lead text-muted">Order {{$order->id}}</p>
                <span class="badge badge-success">{{$order->status}}</span>
                <br><br>
            </h3>
            <small class="lead display-6"><i class="fa fa-clock-o" aria-hidden="true"></i> On
                {{$order->created_at}}</small>
        </div>
        <div class="col-md-2">
            <a href="{{route('user.orders.details',$order->id)}}" class="btn btn-primary float-right"> Details</a>
        </div>
    </div>

</div>
@empty
<div class="alert alert-warning" role="alert">
    <h3 class="alert-heading"><i class="fa fa-info-circle" aria-hidden="true"></i>
        No Orders
    </h3>
    <p>You haven't order anything yet . what are you waiting for ? You will Enjoy Our Books if
        You take A look at <a href="http://127.0.0.1:8000/library"><strong>The
                Library</strong></a>.</p>

</div>
@endforelse
{{$userOrders->links()}}

@include('includes.alerts')

@endsection
