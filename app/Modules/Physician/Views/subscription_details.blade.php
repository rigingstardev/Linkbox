@extends('layouts.layout2')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

        <h1>Subscription Details</h1>
    </section>



    <!-- Main content -->
    <section class="content">


        <div class="content-sub mrgn-btm-20 pdng-0">
            <div class="content-sub-heading"> 
                <div class="col-sm-12">
                    <b>Current Plan Details</b>

                </div>
                <div class="clearfix"></div>
            </div>

            <div class="content-area-sub">


                <div class="col-xs-12 patiant-details-data">


                    <div class="row mrgn-btm-10"><div class="col-xs-12 col-sm-5 col-md-4 col-lg-2">Current Subscription Plan</div><div class="col-xs-12 col-sm-7 col-md-8 col-lg-9"><b class="txt-blue">: Monthly Plan</b></div></div>
                    <div class="row mrgn-btm-10"><div class="col-xs-12 col-sm-5 col-md-4 col-lg-2">Last Charged</div><div class="col-xs-12 col-sm-7 col-md-8 col-lg-9"><b class="txt-blue">: US $49 - December 11, 2015</b></div></div>
                    <div class="row mrgn-btm-10"><div class="col-xs-12 col-sm-5 col-md-4 col-lg-2">Expires On</div><div class="col-xs-12 col-sm-7 col-md-8 col-lg-9"><b class="txt-blue">: January 11, 2016</b></div></div>

                    <div class="btn-wrap cncl-subscription"><button type="button" class="btn btn-third not-done">Cancel Subscription</button></div>
                </div>


            </div>
        </div>



        <div class="content-sub mrgn-btm-20 pdng-0">
            <div class="content-sub-heading"> 
                <div class="col-sm-12">
                    <b>Upgrade Subscription</b>

                </div>
                <div class="clearfix"></div>
            </div>

            <div class="content-area-sub">



                <div class="col-xs-12 col-sm-6 col-md-5 col-lg-3">
                    <div class="subcription-main"><h2>Yearly</h2>
                        <span class="doller">$</span>
                        <span class="price">149</span>
                        <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#myModal149">PURCHASE</button>


                        <!-- Modal -->
                        <div class="modal fade" id="myModal149" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Credit Card Details</h4>
                                    </div>
                                    <div class="modal-body">

                                        <div class="col-xs-12 mrgn-btm-15">
                                            <span class="display-block mrgn-btm-10"> Enter Credit Card Number</span>
                                            <div class="input-group">
                                                <input type="text" class="form-control"/>
                                                <span class="input-group-addon">
                                                    <i>
                                                        <img src="{{asset('assets/physician/images/visa.png')}}"> 
                                                        <img src="{{asset('assets/physician/images/MC.png')}}"> 
                                                        <img src="{{asset('assets/physician/images/crd3.png')}}"> 
                                                        <img src="{{asset('assets/physician/images/crd4.png')}}">
                                                    </i>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="col-sm-8">
                                            <span class="display-block mrgn-btm-10">Expiry Date</span>
                                            <div class="row">

                                                <div class="col-sm-6"> <select id="basic" class="selectpicker mrgn-btm-10  show-tick form-control">
                                                        <option>MM</option>
                                                        <option>Jan</option>
                                                        <option>Feb</option>
                                                        <option>Mar</option>
                                                    </select></div>

                                                <div class="col-sm-6"> <select id="basic" class="selectpicker mrgn-btm-10  show-tick form-control">
                                                        <option>YY</option>
                                                        <option>2016</option>
                                                        <option>2015</option>
                                                        <option>2014</option>
                                                    </select></div>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">

                                            <span class="display-block mrgn-btm-10">CVV / Security Code</span>
                                            <input type="text" class="form-control"/>
                                        </div>

                                        <div class="col-sm-12 mrgn-tp-15"><div class="checkbox">
                                                <input id="checkbox22" type="checkbox">
                                                <label for="checkbox22">
                                                    Save for future purchase
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="modal-footer">

                                        <button type="button" class="btn btn-primary mrgn-btm-15">Pay $149.00</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

</div>



</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection