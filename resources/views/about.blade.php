@extends('front.includes.layout')

@section('css')

<style>
    .bg-opacity {

        position: relative;

        background-color: rgb(3 56 86 / 83%);

    }



    .bg-opacity::before {

        content: ' ';

        display: block;

        position: absolute;

        left: 0;

        top: 0;

        width: 100%;

        height: 100%;

        opacity: 0.2;

        background: url('{{asset("images/aboutt.jpg")}}');

        background-size: cover;

        background-position: center center;


    }



    .content {

        position: relative;

        width: 100%;

        height: 280px;

        z-index: 1;

        /* top: 100px; */

        left: 0;

    }

    a {

        text-decoration: none;

    }

    .heading {
        padding-top: 100px;
    }
</style>

@endsection

@section('content')

<!--  -->

<div class="container-fluid p-0" style="padding-top:100px;padding-bottom:100px;">

    <div class="container-fluid p-0">

        <div class="bg-opacity">

            <div class="content">

                <h1 class="text-center text-light heading">About Our Agency</h1>

            </div>

        </div>

    </div>

</div>

<!--  -->

<!--  -->

<div class="container-fluid payment">

    <div class="container mt-5 mb-5">

        <div class="row">

            <div class="col-lg-7 mt-2">

                <h2>About Kwik Insurance</h2>

            </div>

            <div class="col-lg-1"></div>

            <div class="col-lg-4 mt-2">

                <a href="{{route('contact')}}" class="btn button text-uppercase mb-3">Contact Us</a>

                <h5>+1 737 473 2133</h5>
            </div>
            <div class="row mt-3">

                <div class="col-lg-7">
                    <div class="row">
                        <div class="col-lg-6 d-flex justify-content-center">

                            <!-- <img src="{{asset('images/banner.jpg')}}" alt="" class="img-fluid"> -->
                            <img src="{{asset('images/logo4.png')}}" class="img-fluid" alt="...">


                        </div>

                        <div class="col-lg-6">

                            <p>

                                In our agency, we take great pride in the quality of service we provide for our customers.

                            </p>

                            <p>

                                Whether our clients need help filing a claim, processing a payment, or just understanding their insurance coverage we'll always be there ready to help.

                            </p>

                        </div>
                    </div>
                </div>

            </div>

            <div class="row mt-3">

                <div class="col-lg-7">

                    <p>We know our clients and we know insurance, so our clients enjoy the peace of mind that comes with knowing their insurance agency can help them regardless of how big, small, unique, or specific their insurance needs are. With the years of experience we bring to the table there isn't much we haven't seen before, and you never know when that's going to come in handy.</p>

                    <p>Thanks for taking the time to learn more about our agency and please feel free to contact us any time about anything.</p>

                </div>

            </div>

            <div class="col-lg-12">

                <h4 class="text-center pt-5"><a href="{{route('contact')}}">How can we help you today?</a></h4>

            </div>

        </div>

    </div>

</div>

<!--  -->

@endsection