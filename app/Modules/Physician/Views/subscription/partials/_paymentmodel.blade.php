
<!-- Modal -->
<div class="modal fade" id="myModal149" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="fadeContent">
            @if (count((array)$userPlans) === 0)
            {!! Form::open(['url' => route('physician.subscription.create'),'method' => 'post','name'=> 'paymentFrm', 'id'=>'paymentFrm']) !!}
            @else
             {!! Form::open(['url' => route('physician.subscription.upgrade'),'method' => 'post','name'=> 'paymentFrm', 'id'=>'paymentFrm']) !!}
            @endif
           <!--  <form method="POST" action="" name="supportiveDocuploadFrm" id="supportiveDocuploadFrm" role="form" enctype="multipart/form-data"> -->
                {!! csrf_field() !!}
                <span class="payment-errors"></span>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Credit Card Details</h4>
                </div>
                <div class="modal-body">

                    <div class="col-xs-12 mrgn-btm-15">
                        <span class="display-block mrgn-btm-10"> Enter Credit Card Number</span>
                        <!-- <div id="card-element" class="field"></div>  -->                     
                        <div class="input-group">
                           <!--  <input type="text" class="form-control"/> -->
                            {!! Form::text('number', '',['class'=>'form-control','id'=>'number','data-stripe'=>"number",'maxlength' => '16']) !!}
                            <span class="input-group-addon card-thumbs">
                                <i>
                                    <img name="Visa" title="visa" class="" src="{{asset('assets/physician/images/visa.png')}}"> 
                                    <img name="MasterCard" title="Master Card" class="" src="{{asset('assets/physician/images/MC.png')}}"> 
                                    <img name="American Express" title="American Express" class="" src="{{asset('assets/physician/images/crd3.png')}}"> 
                                    <img name="Diners Club" title="Diners Club" class="" src="{{asset('assets/physician/images/crd4.png')}}">
                                </i>
                            </span>
                        </div>
                    </div>
                    <div class="otherDetails">
                        <div class="col-sm-8">
                            <span class="display-block mrgn-btm-10">Expiry Date</span>
                            <div class="row">

                                <div class="col-sm-6">
                                    {!! Form::selectMonth('exp_month', '' , ['id'=>'exp_month','class' => 'selectpicker mrgn-btm-10  show-tick form-control','data-stripe'=>"exp_month"],'%b') !!}
                                </div>
                                <div class="col-sm-6"> 
                                    {!! Form::selectYear('exp_year',Carbon\Carbon::now()->year, (Carbon\Carbon::now()->year)+20, '', ['id'=>'exp_year','class' => 'selectpicker mrgn-btm-10  show-tick form-control','data-stripe'=>"exp_year"]) !!}
                                </div> 
                            </div>
                        </div>

                        <div class="col-sm-4">

                            <span class="display-block mrgn-btm-10">CVV / Security Code</span>                       
                            {!! Form::text('cvc', '',['class'=>'form-control','id'=>'cvc','data-stripe'=>"cvc"]) !!}
                        </div>
                        <div class="col-sm-12 mrgn-tp-15">
                            <div class="checkbox">                            
                                {!! Form::checkbox("savedetails", 1, '',['id'=>"savedetails"]) !!} 
                                <label for="savedetails">
                                    Save for future purchase
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="modal-footer">
                    {!! Form::hidden('plan', '',['id'=>'plan']) !!}
                    {!! Form::hidden('token', 0 ,['id'=>'token']) !!}
                    <button type="submit" class="btn btn-primary mrgn-btm-15 payment">  
                        <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span>
                        Pay <span class="amountcls">$149.00</span>                        
                    </button>    
                    <!-- <button class="btn btn-primary mrgn-btm-15">
                        <span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Loading...</button>      -->           
                    <div class="dberror"></div>  
                </div>                
            {!! Form::close() !!}
        </div>
        </div>
    </div>
</div>