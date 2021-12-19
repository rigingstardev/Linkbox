@if ($message = Session::get('status'))
<div class="alert alert-success">
   <button type="button" class="close" data-dismiss="alert"></button>

   <i class="fa fa-check-circle fa-lg fa-fw"></i> 
   @if(is_array($message)) @foreach ($message as $m) {{ $m }} @endforeach
   @else {{ $message }} @endif  

</div>
@endif 
@if ($message = Session::get('success'))
<div class="alert alert-success">
   <button type="button" class="close" data-dismiss="alert"></button>

   <i class="fa fa-check-circle fa-lg fa-fw"></i> 
   @if(is_array($message)) @foreach ($message as $m) {{ $m }} @endforeach
   @else {{ $message }} @endif  

</div>
@endif 
@if ($message = Session::get('error'))
<div class="alert alert-danger">
   <button type="button" class="close" data-dismiss="alert"></button>
   <strong>
      <i class="fa fa-times-circle fa-lg fa-fw"></i> 
      @if(is_array($message)) @foreach ($message as $m) {{ $m }} @endforeach
      @else {{ $message }} @endif  
   </strong>
</div>
@endif 
@if ($message = Session::get('warning'))
<div class="alert alert-warning">
   <button type="button" class="close" data-dismiss="alert"></button>
   <strong>
      <i class="fa fa-exclamation-circle fa-lg fa-fw"></i> 
      @if(is_array($message)) @foreach ($message as $m) {{ $m }} @endforeach
      @else {{ $message }} @endif  
   </strong>
</div>
@endif 
@if ($message = Session::get('info'))
<div class="alert alert-info">
   <button type="button" class="close" data-dismiss="alert"></button>
   <strong>
      <i class="fa fa-info-circle fa-lg fa-fw"></i> 
      @if(is_array($message)) @foreach ($message as $m) {{ $m }} @endforeach
      @else {{ $message }} @endif  
   </strong>
</div>
@endif
@if(count($errors) > 0)
<div class="alert alert-danger">
   @foreach ($errors->all() as $error)
   <div>
       <!--<i class="fa fa-times-circle fa-lg fa-fw"></i>-->
      {{ $error }}
   </div>
   @endforeach
</div>
@endif