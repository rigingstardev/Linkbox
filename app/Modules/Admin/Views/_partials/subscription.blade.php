<div class="content-sub mrgn-btm-20 pdng-0">
   <div class="content-sub-heading">
      <div class="col-sm-12"><b>Current Subscriptions Details</b></div>
      <div class="clearfix"></div>
   </div>
   <div class="content-area-sub subscri_bg">

      <div class="col-sm-12 phy-detail-label subscription">
         <p><label>Current Subscription Plan :</label><span>{!! ($userActivePlan)?$userActivePlan->plan->name:"NIL" !!}</span></p>
         @if ($userActivePlan)
            <p><label>Last Charged :</label><span>{!! ($userActivePlan)? $userActivePlan->plan->currency . $userActivePlan->plan->amount.", " . Carbon\Carbon::parse($userActivePlan->created_at)->format('F d, Y')." US ": "" !!}</span></p>
            <p><label>Expires On :</label><span>{!! ($userActivePlan)? Carbon\Carbon::parse($data['physician']['subscription_ends_at'])->format('F d, Y')  : "" !!}</span></p>
         @endif
      </div>
      <div class="clearfix"></div> </div>
</div>