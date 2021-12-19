@extends('layouts.layout2')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Subscription Details</h1>
    </section>
    @include('includes.alerts')
    <!-- Main content -->
    <section class="content">      
       <?php $title = 'Payment Plans'; ?>       
        @if (count((array)$userPlans) != 0)
          <?php $title = 'Upgrade Subscription'; ?> 
          @include('Physician::subscription.partials._current')
        @endif
        <div class="content-sub mrgn-btm-20 pdng-0">
            <div class="content-sub-heading"> 
                <div class="col-sm-12">
                    <b>{!! $title !!}</b>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="content-area-sub">
                @if (count((array)$userPlans) === 0)
                <div class="col-sm-12">
                    <p class="mrgn-btm-20">Purchase a payment plan to start creating Question Sets.</p>
                </div>
                @endif
                @forelse ($plans as $plan)                   
                    <div class="col-xs-12 col-sm-6 col-md-5 col-lg-3">
                        <div class="subcription-main"><h2>{!! $plan->name !!}</h2>
                            <span class="doller">{!! $plan->currency !!}</span>
                            <span class="price">{!! $plan->amount !!}</span>
                            <button type="button" class="btn btn-primary btn-block purchase" data-amount="{!! $plan->currency !!} {!! $plan->amount !!}" data-plan="{!! $plan->plan_id !!}" data-toggle="modal" data-target="#myModal149">PURCHASE</button> 
                        </div>
                    </div>
                @empty
                     <div class="col-xs-12 col-sm-6 col-md-5 col-lg-3">
                        <p>No plans found.</p>
                     </div>
                @endforelse  
            </div>
        </div>
        @include('Physician::subscription.partials._paymentmodel')
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection
@section('page_scripts')
<script type="text/javascript">
Stripe.setPublishableKey("{{env('STRIPE_KEY')}}");  
</script>
<script type="text/javascript">
$(document).ready(function(){
    $('.glyphicon-refresh-animate').hide();
    $(".purchase").click(function(){
        $("#myModal149 .payment span.amountcls").html($(this).data('amount'));
        @if (!empty(\Auth::user()->default_card))          
            $('#myModal149 select,#myModal149 input:not([type=hidden]').prop('disabled', true);
            $('#myModal149 #number').val("{!! str_pad(\Auth::user()->card_last_four, 16, "*", STR_PAD_LEFT) !!}");          
            $('#myModal149 .otherDetails').prop('hidden',true);
            $('#myModal149 .card-thumbs').find('img[name="{!! \Auth::user()->card_brand !!}"]').addClass('card-active');
            $('#myModal149 .modal-footer').prepend('<button type="button" class="editcard btn btn-primary mrgn-btm-15" ><span aria-hidden="true">Edit Card</span></button>');
            $('#myModal149 #token').val(1);
        @endif
        $("#myModal149 #plan").val($(this).data('plan'));
//        $("#myModal149").modal('show');
    });   
});
$(document).on('submit','#paymentFrm',function(e){
    e.preventDefault();
    removeWithClass(params.errorClass); 
    //$('.payment').attr('disabled',true);   
    $('#paymentFrm button').prop('disabled', true);  
    var cardType = 'Unknown';var cardactive = 'Unknown';
    // Request a token from Stripe: 
    var item = {}; var error = false; 
    // Get the values:
    var ccNum = $('#number').val(),
        cvcNum = $('#cvc').val(),
        expMonth = $('#exp_month').val(),
        expYear = $('#exp_year').val();
    
    // If Card Saved for Future Use then Submit the Form
    if(1 == $('#token').val()) {      
      PaymentStripe();
      return;
    }
    if(ccNum) {
        if (!Stripe.card.validateCardNumber(ccNum)) {        
            error = true;       
            item['number'] = ['The credit card number appears to be invalid.'];       
        }else{            
            cardactive = Stripe.card.cardType(ccNum);             
            addClassActive(cardactive);
        }
    }else{
       error = true;
       item['number'] = ['Specify Credit Card Number.']; 
    }     
    // Validate the CVC:
    if(cvcNum){
       if (!Stripe.card.validateCVC(cvcNum)) {        
            error = true;        
            item['cvc'] = ['The CVC number appears to be invalid.'];        
        }
    }else{
       error = true;
       item['cvc'] = ['Specify CVC.']; 
    }
    if(expMonth == "") {
        error = true;
        item['exp_month'] = ['Specify Expiry Month.']; 
    } 
    if(expYear == "") {
        error = true;
         item['exp_year'] = ['Specify Expiry Year.']; 
    } 
    if(expMonth && expYear){
        if (!Stripe.card.validateExpiry(expMonth, expYear)) {        
            error = true;
            item['exp_month'] = ['The expiration date appears to be invalid.'];           
        }
    } 
    if (!error) {
        loading($('.payment'));
        Stripe.card.createToken({
          number: $('#number').val(),
          cvc: $('#cvc').val(),
          exp_month: $('#exp_month').val(),
          exp_year: $('#exp_year').val()
        }, stripeResponseHandler);
    }else{        
        $.each(item, function (k, v) { 
            if('number' == k)
              $('.input-group').after('<div class="' + params.errorClass + '">' + v + '</div>');
            else
             $('#' + k).after('<div class="' + params.errorClass + '">' + v + '</div>');                 
        }); 
        $('#paymentFrm button').prop('disabled', false);
    }
    // Prevent the form from being submitted:
    return false;   
})
function stripeResponseHandler(status, response) {
  // Grab the form:
  var $form = $('#paymentFrm');
  if (response.error) { // Problem!
    unloading($('.payment')); 
    // Show the errors on the form:
    //$form.find('.dberror').text(response.error.message);   
    $form.find('.dberror').after('<div class="'+ params.errorClass+'">' + response.error.message + '</div>');   
    $('#paymentFrm button').prop('disabled', false); 
  } else { // Token was created!
    token = response.id;   
    $('#paymentFrm button').prop('disabled', true);       
    // Insert the token ID into the form so it gets submitted to the server:
    $form.append($('<input type="hidden" name="stripeToken">').val(token));
    $form.append($('<input type="hidden" name="stripeCard">').val(response.card.id));
    PaymentStripe();   
  }
};

// Method to submit the Payment Form
var PaymentStripe = function(){   
    $form = $('#paymentFrm'); 
    $('#paymentFrm select,#paymentFrm input').prop('readonly', true); 
    loading($('.payment'));
    $.ajax({
            type: $form.attr('method'),
            url: $form.attr('action'),
            data: $form.serialize(),
            success: function(response, status) {
               // $('.payment').attr('disabled',false);  
                $('#paymentFrm button').prop('disabled', false); 
                $('#paymentFrm select,#paymentFrm input').prop('readonly', false); 
                var response = JSON.parse(response);                                         
                unloading($('.payment'));                
                if(response.success){                     
                    $("#paymentFrm")[0].reset();                   
                    $('.textboxErr').remove();
                    $("#myModal149").modal('hide');
                    if(response.redirectUrl) {                       
                        setTimeout(function () {
                              $(location).attr("href", response.redirectUrl);
                        }, 500);
                    }
                 }else {            
                    showDBChangeAlert('error', params.dbChangeError);            
                 }         
            },
            error: function (response) {   
                //$('.payment').attr('disabled',false);   
                $('#paymentFrm button').prop('disabled', false);
                $('#paymentFrm select,#paymentFrm input').prop('readonly', false);  
                unloading($('.payment'));
                showValidation(response, params.errorClass);
            }
    });
    return false;
}
$('#myModal149').on('hidden.bs.modal', function (e) {
    removeWithClass(params.errorClass);
    $('#myModal149 .editcard').remove();
    $(this).find('form')[0].reset();
})
$(document).on('click','.editcard',function(e){
    e.preventDefault(); 
    $('#myModal149 input, #myModal149 select').prop('disabled', false);
    $('#myModal149 .otherDetails').prop('hidden',false);
    $('#myModal149 #number').val('');
    $('#myModal149 #token').val(0);
    $('#myModal149 .card-thumbs img').removeClass('card-active');
    $('#myModal149 .editcard').remove();
});
@if (count((array)$userPlans) != 0)
  $(document).on('click','.cancelSubscription',function(e){ 
    //e.preventDefault();   
    var Confirm =confirm('Are you sure to cancel Subscription?');
    if(Confirm){
       $('button').prop('disabled', true);
       loading($('.cancel'));
       $(this).attr('href',"{!! route('physician.subscription.cancel',$userPlans->plan->plan_id) !!}");
    }
    return Confirm;
  });
@endif
var loading= function(button){
  $('.glyphicon-refresh-animate').show();
}
var unloading= function(button){
  $('.glyphicon-refresh-animate').hide();
}
var addClassActive = function(card) {   
    $('.card-thumbs img').removeClass('card-active');
    $('.card-thumbs').find('img[name="'+card+'"]').addClass('card-active');
}
</script>
@endsection