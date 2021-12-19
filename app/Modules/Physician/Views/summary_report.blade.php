@extends('layouts.layout2')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

        <h1>Summary Report</h1>
    </section>



    <!-- Main content -->
    <section class="content">




        <div class="content-sub mrgn-btm-20 pdng-0">
            <div class="content-sub-heading"> 
                <div class="col-sm-12">
                    <b>Back Pain</b>

                    <a href="#" class="edit pull-right txt-blue not-done" type="button" class="btn" data-toggle="tooltip" data-placement="top" title="Print"><i class="fa fa-print" ></i></a>
                  <!-- <a href="#" class="edit pull-right txt-blue dropdown-toggle"  data-toggle="dropdown" type="button" class="btn" data-toggle="tooltip" data-placement="top" title="Email"><i class="fa fa-envelope-o" ></i></a>-->

                    <ul class="navbar-right mrgn-rgt-15">
                        <li class="dropdown email-option">
                            <a class="dropdown-toggle edit txt-blue" href="#" data-toggle="dropdown" id="navLogin" data-placement="top" title="Email"><i class="fa fa-envelope-o" ></i></a>
                            <div class="dropdown-menu summary-email">
                                <i class="arrow-point" aria-hidden="true"></i>
                                <form class="form" id="formLogin"> 
                                    <input type="email" class="form-control" id="" placeholder="Enter Physician’s Email " >

                                    <div class="button-wrap"> <button type="button" id="btnLogin" class="btn btn-primary mrgn-tp-20">Send</button>

                                    </div>

                                </form>
                            </div>
                        </li>
                    </ul>         


                </div>
                <div class="clearfix"></div>
            </div>

            <div class="content-area-sub">
                <div class="col-sm-12 paragraph">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam interdum ut neque varius tempor. Donec ligula nibh, eleifend ac orci eu, condimentum maximus purus. Donec mollis tellus vel neque suscipit, eu maximus lorem consequat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam  interdum ut neque varius tempor. Donec ligula nibh, eleifend ac orci eu, condimentummaximus purus. Donec mollis tellus vel neque suscipit, eu maximus  lorem consequat.</p>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam interdum ut neque varius tempor. Donec ligula nibh, eleifend ac orci eu, condimentum maximus purus. Donec mollis tellus vel neque suscipit, eu maximus lorem consequat.</p>
                </div>
            </div>
        </div>




        <section class="content-sub-header">


            <div class="col-xs-4 col-sm-3 col-md-2 col-lg-1 pull-right">
                <div class="row">   
                    <button type="button" class="btn btn-third btn-block  mrgn-btm-15"  onclick="location.href = '{{url('physician/patientDetails')}}'" >Back</button>
                </div></div>
        </section>

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection