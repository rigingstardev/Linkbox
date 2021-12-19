@extends('layouts.default')

@section('content')
<!--Content Area-->
<div class="about-content-area" id="about-us">

    <div class="container">

        <div class="about-text-main">

            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 about-img pull-right"><div class="row"><img src="{{asset('assets/physician/images/about-img.jpg')}}"/></div></div>

            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 about-text">
                <h1>MISSION</h1> 
            <p>Our mission at LinkBox, is to facilitate quality documentation with minimal effort from the Physician. Think of us as a mobile scribe. We also aim to decrease communication obstacles between doctors and patients by eliminating the laptop, desktop and large tablet from the equation, replacing it with small mobile devices. We want our Physicians to walk out of the exam room with their HPI paperwork already finished. It is our desire for Physicians to be able to end their day without a stack of charts to face before they go home, while also feeling completely confident that quality documentation has been completed. This will satisfy both coding and care management needs. Our goal is to help the Doctor see more patients faster and
                get home sooner.</p>
            </div>

            <div class="clearfix"></div>
        </div>

        <div class="mission">
            <h1>OUR STORY</h1>
                <p>After two back to back 12 hour days on call during Father's Day weekend, and subsequently missing all the festivities in his honor, our founder was determined to create a solution to help Doctors more efficiently see their patients while also increasing quality of care. As a result, LinkBox was born - a mobile software system that removes barriers between the physician and their patients, while automating the HPI documentation process. At last, user friendly technology that delivers more satisfied patients as it offers Doctors more time with their family. As the saying goes,</p>

                <h3>"Happier Doctors equal happier patients."</h3>
        </div>

    </div>
</div>
<!--Content Area End-->
@endsection

@section('contact')
@include('includes.contact')
@endsection