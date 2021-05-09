@extends('layouts.app')
@section('extra-styles')
<link rel="stylesheet" href="{{asset('css/dashboard.css')}}">
@endsection
@section('content')

<div class="main-content">

    <!-- Header -->
    <div class="mt-5 header pb-8 pt-5 pt-lg-8 d-flex align-items-center" id="dashboard-header">
        <!-- Mask -->
        <span class="mask bg-gradient-default opacity-8"></span>
        <!-- Header container -->
        <div class="container-fluid   align-items-center">
            <div class="row">
                <div class="col-lg-6 text-center offset-md-3">
                    <h1 class="display-2 text-white text-capitalize"><img width="53" height="53"
                            src="/storage/images/design/logos/mylogo.png" alt=""> Hello {{auth()->user()->name}} </h1>
                    <p class="text-white mt-0 mb-5">This is your Dashboard page. You can see All the Info Related To
                        your account</p>
                    <a href="{{route('user.profile')}}" class="btn btn-info"><i class="fa fa-cogs"></i> Account
                        Setting</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content -->



    <div class="container-fluid  mt--7">

        <div class="row">

            <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
                <div class="card card-profile shadow ">
                    <div class="row justify-content-center">
                        <div class="col-lg-3 order-lg-2">
                            <div class="card-profile-image">

                                <img src="{{auth()->user()->avatar}}" class="rounded-circle">

                            </div>
                        </div>
                    </div>
                    <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                        <div class="d-flex justify-content-between">
                            <a href="{{route('library')}}" class="btn btn-sm btn-info mr-4"><i class="fa fa-book"></i>
                                Library</a>
                            <a href="{{route('library')}}" class="btn btn-sm btn-default float-right"><i
                                    class="fa fa-comment"></i> Blog</a>
                        </div>
                    </div>
                    <div class="card-body pt-0 pt-md-4">
                        <div class="row">
                            <div class="col">
                                <div class="card-profile-stats d-flex justify-content-center mt-md-5">
                                    <div class="ml-5">
                                        <a href="{{route('cart')}}">
                                            <span class="heading"><span
                                                    class="badge badge-success">{{$cartCount}}</span></span>
                                            <span class="description">Cart</span>
                                        </a>

                                    </div>
                                    <div>
                                        <a href="{{route('user.orders')}}">
                                            <span class="heading"><span
                                                    class="badge badge-info">{{$ordersCount}}</span></span>
                                            <span class="description">Orders</span>
                                        </a>
                                    </div>
                                    <div>
                                        <a href="{{route('cart')}}">
                                            <span class="heading"><span
                                                    class="badge badge-danger">{{$wishlistCount}}</span></span>
                                            <span class="description">Wishlist</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <h3 class="text-capitalize">
                                {{auth()->user()->name}}
                            </h3>
                            <div class="h5 font-weight-300 text-capitalize">
                                <i class="ni location_pin mr-2 "></i>{{auth()->user()->city  }},
                                {{auth()->user()->country}}
                            </div>
                            <div class="h5 mt-4">
                                <i class="ni business_briefcase-24 mr-2"></i>{{auth()->user()->phone  }}
                            </div>
                            <div>
                                <i class="ni education_hat mr-2"></i><a class="btn btn-success hover-wider"
                                    href="{{route('library')}}"><i class="fa fa-book"></i> See Some Books</a>
                            </div>
                            <hr class="my-4">
                            <p>{{auth()->user()->bio}}</p>
                            <p class="text-info">Register Date :
                                {{Carbon\Carbon::parse(auth()->user()->created_at)->format(' d M  Y')}}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">My account</h3>
                            </div>
                            <div class="col-4 text-right">
                                <a href="{{route('user.profile')}}" class="btn btn-sm btn-primary"><i
                                        class="fa fa-cog"></i> Setting</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form>
                            <h6 class="heading-small text-muted mb-4">User information</h6>
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="input-username">Full name</label>
                                            <input type="text" id="input-username" disabled
                                                class="form-control form-control-alternative" placeholder="Full name"
                                                value="{{auth()->user()->name}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-email">Email address</label>
                                            <input type="email" id="input-email"
                                                class="form-control form-control-alternative" disabled
                                                placeholder="Email address" value="{{auth()->user()->email}}">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <hr class="my-4">
                            <!-- Address -->
                            <h6 class="heading-small text-muted mb-4">Contact information</h6>
                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="input-phone">Phone</label>
                                            <input id="input-phone" class="form-control form-control-alternative"
                                                placeholder="Phone number is empty" disabled
                                                value="{{auth()->user()->phone}}" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="input-address">Address</label>
                                            <input id="input-address" class="form-control form-control-alternative"
                                                placeholder="Address is empty" value="{{auth()->user()->address}}"
                                                disabled type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="input-city">City</label>
                                            <input type="text" id="input-city" disabled
                                                class="form-control form-control-alternative"
                                                placeholder="City is empty" value="{{auth()->user()->city}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="input-state">State</label>
                                            <input type="text" id="input-state" disabled
                                                class="form-control form-control-alternative"
                                                placeholder="State is empty" value="{{auth()->user()->state}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group focused">
                                            <label class="form-control-label" for="input-country">Country</label>
                                            <input type="text" id="input-country" disabled
                                                class="form-control form-control-alternative"
                                                placeholder="Country is empty" value="{{auth()->user()->country}}">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-country">Postal code</label>
                                            <input type="number" id="input-postal-code" disabled
                                                value="{{auth()->user()->zip}}"
                                                class="form-control form-control-alternative"
                                                placeholder="Postal code is empty">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="my-4">
                            <!-- Description -->
                            <h6 class="heading-small text-muted mb-4">About me</h6>
                            <div class="pl-lg-4">
                                <div class="form-group focused">
                                    <label>About Me</label>
                                    <textarea rows="4" class="form-control form-control-alternative" disabled
                                        placeholder="A few words about you ...">{{auth()->user()->bio}}</textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

