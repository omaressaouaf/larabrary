@extends('layouts.app')

@section('content')
{{-- Breadcrumb --}}
<div aria-label="breadcrumb " class="breadcrumb py-1 " style="margin-top: 92px">

    <div class="container">

        <ol class="breadcrumb breadcrumb-nav">

            <li class="breadcrumb-item "><a href="{{route('landing')}}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page"> About Us </li>


        </ol>


    </div>

</div>
{{-- End BreadCrumb --}}
<!-- About-->
{{-- <section class="page-section" id="about"> --}}
<div class="container mt-4 ">
    <div class="text-center">
        <h2 class="section-heading text-uppercase display-4">About Us</h2>
        <h3 class="section-subheading   text-muted mb-5 mt-5">Lorem ipsum dolor sit amet consectetur.</h3>
    </div>
    <ul class="timeline">
        <li>
            <div class="timeline-image"><img class="rounded-circle img-fluid" src="" alt="" /></div>
            <div class="timeline-panel">
                <div class="timeline-heading">
                    <h4>2009-2011</h4>
                    <h4 class="subheading">Our Humble Beginnings</h4>
                </div>
                <div class="timeline-body">
                    <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt ut voluptatum
                        eius sapiente, totam reiciendis temporibus qui quibusdam, recusandae sit vero unde, sed,
                        incidunt et ea quo dolore laudantium consectetur!</p>
                </div>
            </div>
        </li>
        <li class="timeline-inverted">
            <div class="timeline-image"><img class="rounded-circle img-fluid" src="" alt="" /></div>
            <div class="timeline-panel">
                <div class="timeline-heading">
                    <h4>March 2011</h4>
                    <h4 class="subheading">An Agency is Born</h4>
                </div>
                <div class="timeline-body">
                    <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt ut voluptatum
                        eius sapiente, totam reiciendis temporibus qui quibusdam, recusandae sit vero unde, sed,
                        incidunt et ea quo dolore laudantium consectetur!</p>
                </div>
            </div>
        </li>
        <li>
            <div class="timeline-image"><img class="rounded-circle img-fluid" src="" alt="" /></div>
            <div class="timeline-panel">
                <div class="timeline-heading">
                    <h4>December 2012</h4>
                    <h4 class="subheading">Transition to Full Service</h4>
                </div>
                <div class="timeline-body">
                    <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt ut voluptatum
                        eius sapiente, totam reiciendis temporibus qui quibusdam, recusandae sit vero unde, sed,
                        incidunt et ea quo dolore laudantium consectetur!</p>
                </div>
            </div>
        </li>
        <li class="timeline-inverted">
            <div class="timeline-image"><img class="rounded-circle img-fluid" src="" alt="" /></div>
            <div class="timeline-panel">
                <div class="timeline-heading">
                    <h4>July 2014</h4>
                    <h4 class="subheading">Phase Two Expansion</h4>
                </div>
                <div class="timeline-body">
                    <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt ut voluptatum
                        eius sapiente, totam reiciendis temporibus qui quibusdam, recusandae sit vero unde, sed,
                        incidunt et ea quo dolore laudantium consectetur!</p>
                </div>
            </div>
        </li>
        <li class="timeline-inverted">
            <div class="timeline-image">
                <h4>
                    Be Part
                    <br />
                    Of Our
                    <br />
                    Story!
                </h4>
            </div>
        </li>
    </ul>
</div>

@endsection