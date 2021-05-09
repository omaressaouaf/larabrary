@extends('layouts.account')
@section('account-extra-styles')

<style>
    .pass_show {
        position: relative
    }

    .pass_show .ptxt {

        position: absolute;

        top: 50%;

        right: 10px;

        z-index: 1;

        color: #f36c01;

        margin-top: -10px;

        cursor: pointer;

        transition: .3s ease all;

    }

    .pass_show .ptxt:hover {
        color: #333333;
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
    <h6 class="text-right lead display-4 text-success">Change Password</h6>
</div>



@include('includes.alerts')
<div class="container">
    <div class="row">
        <div class="col-sm-8">

            <form action="{{route('user.password.update')}}" method="POST">
                @csrf
                @method('PUT')

                <label>Current Password</label>
                <div class="form-group pass_show">
                    <input  type="password" name="old_password" class="form-control"
                        placeholder="Current Password">
                </div>
                <label>New Password</label>
                <div class="form-group pass_show">
                    <input required type="password" name="new_password" class="form-control" placeholder="New Password">
                </div>
                <label>Confirm Password</label>
                <div class="form-group pass_show">
                    <input required type="password" name="confirm_password" class="form-control"
                        placeholder="Confirm Password">
                </div>
                <div class="btn-group">
                    <button type="submit" class="btn btn-danger mr-3"><i class="fa fa-check"></i>
                        Save</button>
                    <a href="{{route('user.profile')}}" class="btn btn-primary-schema">
                        <i class="fa fa-close"></i> Cancel</a>
                </div>


            </form>
        </div>
    </div>
</div>


@endsection
@section('account-extra-scripts')
<script>
    $(document).ready(function(){
    $('.pass_show').append('<span class="ptxt">Show</span>');
    });


    $(document).on('click','.pass_show .ptxt', function(){

    $(this).text($(this).text() == "Show" ? "Hide" : "Show");

    $(this).prev().attr('type', function(index, attr){return attr == 'password' ? 'text' : 'password'; });

});

</script>

@endsection
