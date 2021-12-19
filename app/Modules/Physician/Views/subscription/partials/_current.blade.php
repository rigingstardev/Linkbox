 <div class="content-sub mrgn-btm-20 pdng-0">
    <div class="content-sub-heading"> 
        <div class="col-sm-12">
            <b>Current Plan Details</b>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="content-area-sub">
        <div class="col-xs-12 patiant-details-data">
            <div class="row mrgn-btm-10"><div class="col-xs-12 col-sm-5 col-md-4 col-lg-2">Current Subscription Plan</div><div class="col-xs-12 col-sm-7 col-md-8 col-lg-9"><b class="txt-blue">: {!!  $userPlans->plan->name !!}</b></div></div>
            <div class="row mrgn-btm-10"><div class="col-xs-12 col-sm-5 col-md-4 col-lg-2">Last Charged</div><div class="col-xs-12 col-sm-7 col-md-8 col-lg-9"><b class="txt-blue">: US {!!  $userPlans->plan->currency !!} {!!  $userPlans->plan->amount !!} - {!!  Carbon\Carbon::parse($userPlans->created_at)->format('F d, Y') !!}</b></div></div>
            <div class="row mrgn-btm-10"><div class="col-xs-12 col-sm-5 col-md-4 col-lg-2">Expires On</div><div class="col-xs-12 col-sm-7 col-md-8 col-lg-9"><b class="txt-blue">: {!!  Carbon\Carbon::parse(\Auth::user()->subscription_ends_at)->format('F d, Y') !!}</b></div></div>
            <div class="btn-wrap cncl-subscription">
                <a href="javascript:void(0);" class="cancelSubscription"><button type="button" class="btn btn-third cancel">Cancel Subscription</button></a>
            </div>
        </div>
    </div>
</div>