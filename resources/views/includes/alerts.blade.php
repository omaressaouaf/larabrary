@if(session()->has("success_alert"))

<div class="alert alert-success  alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <h5> <strong> <i class="fa fa-check-circle"></i></strong> {{session()->get('success_alert')}}</h5>
</div>

@endif
@if(session()->has("error_alert"))

<div class="alert alert-danger alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <h5> <strong> <i class="fa fa-exclamation-circle"></i></strong> {{session()->get('error_alert')}}</h5>
</div>

@endif
@if(count($errors) >0)
@foreach ($errors->all() as $error)
<div class="alert alert-danger alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <h5> <strong> <i class="fa fa-exclamation"></i></strong> {{$error}}</h5>
</div>
@endforeach


@endif