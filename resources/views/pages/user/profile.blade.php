@extends('layouts.account')


@section('account-content')




<div class="d-flex justify-content-between  align-items-center mb-3">
    <div class="d-flex flex-row align-items-center back">
        <a href="{{route('user.dashboard')}}" class="btn btn-info">
            <i class="fa fa-chevron-left mr-1 mb-1"></i> Back to Dashboard
        </a>
    </div>
    <h6 class="text-right lead display-4 text-success">Edit Profile</h6>
</div>

@if (session()->has('success_alert'))
<div class="alert alert-success  alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <h5> <strong> <i class="fa fa-check-circle"></i></strong>
        {{session()->get('success_alert')}}
    </h5>
</div>

@endif
@if (session()->has('error_alert'))
<div class="alert alert-danger  alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <h5> <strong> <i class="fa fa-exclamation-triangle"></i></strong>
        {!!session()->get('error_alert') !!}
    </h5>
</div>

@endif


<form action="{{route('user.profile.update')}}" method="POST" enctype="multipart/form-data">

    @csrf
    @method("PUT")

    <div class="row mt-3">
        <div class="col-md-12">

            <img class="rounded-circle mb-3" src="{{auth()->user()->avatar}}" width="90">
            @error('avatar')
            <span class="text-danger" role="alert">
                <strong><i class="fa fa-exclamation-circle ml-2"></i> {{$message}}</strong>
            </span>
            @enderror

            <div class="input-group mb-3 mt-2">

                <div class="input-group-prepend" id="inputGroupFileAddon01" style="display: none;">

                    <button type="button" class="input-group-text  btn btn-info"
                        onclick="$('#avatar').val('');$('#upload-file-info').html('Choose new Avatar') ; $('#inputGroupFileAddon01').css('display','none');"><i
                            class="fa fa-close mr-2 "></i> Cancel</button>

                </div>

                <div class="custom-file">


                    <input type="file"
                        class="custom-file-input form-control mr-3 @error('avatar')is-invalid @enderror  " name="avatar"
                        id="avatar" aria-describedby="inputGroupFileAddon01"
                        onchange="$('#upload-file-info').html(this.files[0].name) ; $('#inputGroupFileAddon01').css('display','block')">
                    <label class="custom-file-label " style="overflow: hidden;" id="upload-file-info" for="image">Choose
                        new Avatar</label>




                </div>

            </div>

        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-6">
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                placeholder="Enter Full name" required value="{{old('name') ? old('name') :  auth()->user()->name}}">

            @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror


        </div>
        <div class="col-md-6">
            <input type="email" {{auth()->user()->provider ? 'readonly' : ''}}  class="form-control  @error('email') is-invalid @enderror"
                value="{{old('email') ? old('email') :  auth()->user()->email}}" required
                placeholder="Enter Email Address" name="email">
            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>


    <div class="row mt-3">
        <div class="col-md-12"><input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                placeholder="Enter Phone number" value="{{old('phone') ? old('phone') :  auth()->user()->phone}}"></div>
        @error('phone')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="row mt-3">
        <div class="col-md-12"><input type="text" name="address"
                class="form-control @error('address') is-invalid @enderror" placeholder="Enter Address"
                value="{{old('address') ? old('address') :  auth()->user()->address}}">
        </div>
        @error('address')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="row mt-3">
        <div class="col-md-6">
            <input type="text" class="form-control @error('country') is-invalid @enderror" name="country"
                placeholder="Enter Country" value="{{old('country') ? old('country') :  auth()->user()->country}}">
            @error('country')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="col-md-6">
            <input type="text" class="form-control @error('state') is-invalid @enderror" name="state"
                value="{{old('state') ? old('state') :  auth()->user()->state}}" placeholder="Enter State">
            @error('state')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-6">
            <input type="text" class="form-control @error('city') is-invalid @enderror" placeholder="Enter City"
                name="city" value="{{old('city') ? old('city') :  auth()->user()->city}}">
            @error('city')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="col-md-6">
            <input type="number" class="form-control @error('zip') is-invalid @enderror" placeholder="Enter Postal Code"
                name="zip" value="{{old('zip') ? old('zip') :  auth()->user()->zip}}">
            @error('zip')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-12">
            <textarea name="bio" id="" cols="30" rows="3" placeholder="Enter A brief paragraph about you"
                class="form-control @error('bio') is-invalid @enderror">{{old('bio') ? old('bio') :  auth()->user()->bio}}</textarea>
            @error('bio')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>


    <div class="mt-3 text-right">

        <a href="{{route('user.dashboard')}}" class="btn btn-primary-schema  " type="button">
            <i class="fa fa-close"></i> Cancel and go back to dashboard
        </a>
        <button type="submit" class="btn btn-danger  ">
            <i class="fa fa-check"></i> Save Changes
        </button>

    </div>


</form>


@endsection
