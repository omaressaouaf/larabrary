@extends('layouts.app')

@section('content')
{{-- Breadcrumb --}}
<div aria-label="breadcrumb " class="breadcrumb py-1 " style="margin-top: 92px">

  <div class="container">

    <ol class="breadcrumb breadcrumb-nav">

      <li class="breadcrumb-item "><a href="{{route('landing')}}">Home</a></li>
      <li class="breadcrumb-item active" aria-current="page"> Checkout </li>


    </ol>


  </div>

</div>
{{-- End BreadCrumb --}}



<main class=" pt-4">
  <div class="container wow fadeIn">



    <h1 class="text-center  lead display-4 mb-5"> Complet Your Order</h1>

    {{-- Alerts --}}
    @include('includes.alerts')
    {{-- End Alerts --}}

    {{-- Stripe --}}
    <script src="https://js.stripe.com/v3" type="application/javascript"></script>
    <div class="row">


      <div class="col-md-8 mb-4 ">

        {{-- Checkout Form --}}
        <div class="card">
          <div class="card-header text-center">
            <h4 class="  mb-3">
              <span class="text-dark   text-center">Billing Details </span>

            </h4>
          </div>
          <form class="card-body" action="{{route('checkout.store')}}" method="POST" id="payment-form">
            @csrf
            <!--name-->
            <div class="md-form mb-5">
              <label for="full_name" class="">Full Name</label>
              <input type="text" name="full_name" id="full_name" class="form-control "
                value="{{old('full_name') ? old('full_ame') :  auth()->user()->name}}" placeholder="Your Full Name"
                required>

            </div>


            <!--email-->
            <div class="md-form mb-5">
              <label for="email" class="">Email </label>
              <input autocomplete="email" type="email " name="email" id="email" class="form-control"
                value="{{old('email') ? old('email') :  auth()->user()->email}}" placeholder="youremail@example.com"
                required>

            </div>


            <!--phone-->
            <div class="md-form mb-5">
              <label for="phone" class="">Phone number</label>
              <input autocomplete="phone" type="phone " name="phone" id="phone" class="form-control"
                value="{{old('phone') ? old('phone') :  auth()->user()->phone}}" placeholder="your phone number"
                required>

            </div>

            <!--address-->
            <div class="md-form mb-5">
              <label for="address" class="">Address</label>
              <input type="text" name="address" id="address" class="form-control"
                value="{{old('address') ? old('address') :  auth()->user()->address}}" placeholder="Your Adress"
                required>

            </div>




            <div class="row">


              <div class="col-lg-3 col-md-12 mb-4">

                <!--country-->
                <div class="md-form mb-5">
                  <label for="country" class="">country</label>
                  <input type="text" name="country" id="country" class="form-control"
                    value="{{old('country') ? old('country') :  auth()->user()->country}}" placeholder="Your Country"
                    required>

                </div>

              </div>





              <div class="col-lg-3 col-md-6 mb-4">
                <!--state-->
                <div class="md-form mb-5">
                  <label for="state" class="">state</label>
                  <input type="text" name="state" id="state" class="form-control"
                    value="{{old('state') ? old('state') :  auth()->user()->state}}" placeholder="Your State" required>

                </div>

              </div>
              <div class="col-lg-3 col-md-12 mb-4">

                <!--city-->
                <div class="md-form mb-5">
                  <label for="city" class="">city</label>
                  <input type="text" name="city" id="city" class="form-control"
                    value="{{old('city') ? old('city') :  auth()->user()->city}}" placeholder="Your City" required>

                </div>

              </div>


              <div class="col-lg-3 col-md-6 mb-4">
                {{-- Zip --}}
                <label for="zip">Zip</label>
                <input value="{{old('zip') ? old('zip') :  auth()->user()->zip}}" name="zip" type="number"
                  class="form-control" id="zip" placeholder=" Zip (Postal Code) Code" required>


              </div>


            </div>


            <hr>




            {{-- Payment Details --}}
            <h4 class="text-center">Payment Details</h4>


            <div class="row">
              <div class="form-group col-md-5 offset-md-2">
                <input type="radio" checked name="payment_choice" id="cash_choice" value="cash">
                <label for="cash-radio">Cash on Delivery</label>
              </div>

              <div class="form-group col-md-5">
                <input type="radio" class="" name="payment_choice" id="stripe_choice" value="stripe">
                <label for="stripe-radio">Credit or Debit Card</label>
              </div>

            </div>


            <div id="cash-box">
              <p class="text-info mb-0"><i class="fa fa-info-circle mr-1"></i> Your will pay cash once the order is
                delivered</p>
            </div>
            <div id="stripe-box" style="display: none;">
              <div class="form-group">
                <label for="card-element">
                  Credit or debit card
                </label>
                <div id="card-element">
                  <!-- A Stripe Element will be inserted here. -->
                </div>

                <!-- Used to display form errors. -->
                <div id="card-errors" role="alert"></div>
              </div>
              <div class="form-group">
                <label for="name_on_card">Card Holder name</label>
                <input value="{{ old('card_holder_name')}}" type="text" name="card_holder_name" id="card_holder_name"
                  class="form-control" placeholder="Card holder name">
              </div>
            </div>

            <br>
            {{-- End Payment Details --}}
            <button class="btn btn-danger btn-lg btn-block" id="complet_btn" type="submit">Complet your Order</button>

          </form>
          {{-- End Checkout Form --}}
        </div>


      </div>


      {{-- Cart Summary --}}
      <div class="col-md-4 mb-4">



        <div class="card">
          <div class="card-header ">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
              <span class="text-dark">Your cart</span>
              <span class="badge badge-success badge-pill">{{Cart::count()}}</span>
            </h4>
          </div>
          <div class="card-body">
            <ul class="list-group mb-3 z-depth-1">

              @foreach (Cart::content() as $item)
              <li class="list-group-item d-flex justify-content-between lh-condensed">
                <div>
                  <a href="{{route('library.show',$item->model->slug)}}">
                    <h6 class="my-0">({{$item->qty}}) <h5>{{ Str::limit($item->model->title, 10,$end='...') }}</h5>
                    </h6>
                  </a>
                  <small class="text-muted"> {!! Str::limit($item->model->description, 30,$end='...') !!}</small>
                  <br>
                  <span class="text-muted">${{$item->model->price}}</span>
                </div>

                <img width="80"
                  src="{{$item->model->images()->count() ? $item->model->images()->first()->name : '/storage/images/books/noimagebook.svg' }}"
                  alt="">
              </li>
              @endforeach



            </ul>

          </div>
          <div class="card-footer">


            {{-- Discount Code --}}
            @if(!session()->has('coupon'))
            <div class="card mb-3">
              <div class="card-body">

                <a class="dark-grey-text d-flex text-secondary  justify-content-between" data-toggle="collapse"
                  href="#collapseExample1" aria-expanded="false" aria-controls="collapseExample1">
                  Add a discount code (optional)
                  <span><i class="fa fa-chevron-down pt-1"></i></span>
                </a>

                <div class="collapse" id="collapseExample1">
                  <div class="mt-3">
                    <div class="md-form md-outline mb-0">
                      <form action="{{route('coupon.store')}}" method="POST">
                        @csrf

                        <div class="form-group">
                          <input type="text" required id="code" name="code" class="form-control font-weight-light"
                            placeholder="Enter discount code">
                        </div>

                        <button type="submit" class="btn btn-success">Apply</button>
                      </form>

                    </div>
                  </div>
                </div>
              </div>
            </div>
            @endif

            {{-- End Discount Code --}}
            <li class="list-group-item d-flex justify-content-between">
              <span>SubTotal (USD)</span>
              <strong>${{Cart::SubTotal()}}</strong>

            </li>


            <li class="list-group-item d-flex justify-content-between text-danger">
              <span>Tax (USD)</span>
              <strong>${{Cart::tax()}}</strong>

            </li>
            <li class="list-group-item d-flex justify-content-between">
              <h6>Total (USD)</h6>
              <h6><strong>${{Cart::total()}}</strong></h6>
            </li>
            @if(session()->has('coupon'))
            <li class="list-group-item  justify-content-between">
              <span class="">Coupon ({{session()->get('coupon')['code']}})</span>

              <span class="float-right">Discount (-${{$discount}})</span><br>

              <span>
                <form action="{{route('coupon.destroy')}}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-primary btn-sm mt-2">Remove</button>
                </form>
              </span>

            </li>
            <li class="list-group-item d-flex justify-content-between">
              <span>New SubTotal (USD)</span>
              <strong>${{$newSubTotal}}</strong>

            </li>
            <li class="list-group-item d-flex text-danger justify-content-between">
              <span>New Tax (USD)</span>
              <strong>${{$newTax}}</strong>

            </li>
            <li class="list-group-item d-flex justify-content-between">
              <h6><span>New Total (USD)</span></h6>
              <h6><strong>${{$newTotal}}</strong></h6>

            </li>

            @endif
          </div>





        </div>
      </div>
      {{-- End Cart Summary --}}


    </div>


  </div>
</main>


@endsection
@section('extra-scripts')
<script>
  function performStripePayment() {

// Create a Stripe client.
var stripe = Stripe('pk_test_51HGtizBO6k85rNgh1cUEyAVdsfyRh98jYefuvGI369m3OlNxfhSOyk4MGGZUTNVgCCblKPRrunv838YJAjf9Ify000V11Emz4y');

// Create an instance of Elements.
var elements = stripe.elements();

// Custom styling can be passed to options when creating an Element.
// (Note that this demo uses a wider set of styles than the guide below.)
var style = {
    base: {
        color: '#32325d',
        fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
        fontSmoothing: 'antialiased',
        fontSize: '16px',
        '::placeholder': {
            color: '#aab7c4'
        },

    },
    invalid: {
        color: '#fa755a',
        iconColor: '#fa755a'
    }
};

// Create an instance of the card Element.
var card = elements.create('card', {
    style: style,
    hidePostalCode: true
});

// Add an instance of the card Element into the `card-element` <div>.
card.mount('#card-element');

// Handle real-time validation errors from the card Element.
card.on('change', function (event) {
    var displayError = document.getElementById('card-errors');
    if (event.error) {
        displayError.textContent = event.error.message;
    } else {
        displayError.textContent = '';
    }
});

// Handle form submission.
var form = document.getElementById('payment-form');
form.addEventListener('submit', function (event) {

    event.preventDefault();
    document.getElementById('complet_btn').disabled = true;
    document.getElementById('complet_btn').textContent = "Please Wait ...";

    var options = {
        full_name: document.getElementById("full_name").value,
        email: document.getElementById("email").value,
        name: document.getElementById("card_holder_name").value,
        address_line1: document.getElementById("address").value,
        address_country: document.getElementById("country").value,
        address_state: document.getElementById("state").value,
        address_city: document.getElementById("city").value,
        address_zip: document.getElementById("zip").value,


    }

    stripe.createToken(card, options).then(function (result) {
        if (result.error) {
            // Inform the user if there was an error.
            var errorElement = document.getElementById('card-errors');
            errorElement.textContent = result.error.message;
            document.getElementById('complet_btn').disabled = false;
            document.getElementById('complet_btn').textContent = "Complet your Order";
        } else {
            // Send the token to your server.
            stripeTokenHandler(result.token);
        }
    });
});

// Submit the form with the token ID.
function stripeTokenHandler(token) {
    // Insert the token ID into the form so it gets submitted to the server
    var form = document.getElementById('payment-form');
    var hiddenInput = document.createElement('input');
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('name', 'stripeToken');
    hiddenInput.setAttribute('value', token.id);
    form.appendChild(hiddenInput);

    // Submit the form
    form.submit();
}
}
let payment_choice = document.getElementsByName("payment_choice");
for (let i = 0; i < payment_choice.length; i++) {
payment_choice[i].addEventListener("change", function (e) {
    if (payment_choice[i].value == 'stripe') {

        document.getElementById('card_holder_name').required = true;
        document.getElementById('cash-box').style = "display: none;";
        document.getElementById('stripe-box').style = "display: block;";
        performStripePayment();

    }
    if (payment_choice[i].value == 'cash') {
        document.getElementById('card_holder_name').required = false;
        document.getElementById('stripe-box').style = "display: none;"
        document.getElementById('cash-box').style = "display: block;"


    }
});
}
if(document.getElementById("stripe-box").style.display == 'none'){
  var form = document.getElementById('payment-form');
        form.addEventListener('submit', function (event) {
          document.getElementById('complet_btn').disabled = true;
          document.getElementById('complet_btn').textContent = "Please Wait ...";

        })
}
</script>
@endsection
