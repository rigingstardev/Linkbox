@extends('layouts.layout5')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>@if($questionSets) {{$questionSets->title}}@endif Question Set</h1>
   </section>
   <section class="content  section-class hidden">
      @include('layouts.show_alert_message')
   </section> 
   <!-- Main content -->
   <section class="content content-library" @if($questionSets->bg_image) style="background-image: url({{asset('uploads/question_set/' . $questionSets->bg_image)}})" @endif>
      <div class="content-library-bg"></div>
      <section class="content-sub-header managLib_edit">
         <a href="" class="mrgn-btm-20" data-toggle="modal" data-target="#editImage"><img src="{{asset('assets/admin/images/img-acatar.png')}}">Upload Background Image</a> <div class="clearfix"></div><br>

         <h4 class="pull-left">Questions <span class="txt-blue">@if($questionSets){{count((array)$questionCategories)}}@endif</span></h4>
         <div class="checkbox pull-right set-sponser">
            <input id="checkbox2"  type="checkbox" onclick="setOrResetAdminOptions('s',@if($questionSets){{$questionSets->id}}@endif, 'sponsored')" @if($questionSets &&$questionSets->is_sponsored =='Y' ){{'checked'}}@endif>
                   <label for="checkbox2">
               Set as sponsored
            </label>
         </div>
      </section>
      <div class="content-sub mrgn-btm-20 pdng-0">
         <div class="content-sub-heading ">
            <div class="col-sm-12">
               <b>{{$questionSets->title}}</b>
            </div>
            <div class="clearfix"></div>
         </div>

         <div class="content-area-sub">
            <div class="col-sm-12">
               <p><?php echo nl2br($questionSets->description) ?></p>
            </div>
         </div>
      </div>
      <!--- start displaying questions and options --->
      @include('layouts.question_category')
      <!--- end displaying questions and options --->
      <div class="col-md-12 pdng-lft-0"><button type="button" class="btn btn-third btn-block btn-back mrgn-btm-15 btn-back" onclick="location.href ='{{url('admin/manageLibrary')}}'"> Back</button></div>

   </section>
   <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<div class="modal fade" id="editImage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {!! Form::open(['url' => 'admin/uploadBgImage','class' => 'bootstrap-modal-form', 'id' => 'uploadImage', 'method' => 'post']) !!}
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Upload Background Image</h4>
            </div>
            <div class="modal-body">



                <div class="col-sm-12 mrgn-btm-20">
                    <span class="display-block mrgn-btm-10"> Choose an image</span>
                    {!! Form::file('bg_image',['class' => 'form-control']) !!}
                    {!!  Form::hidden('qset_id', $questionSets->id) !!}
                </div>


                <div class="clearfix"></div>

            </div>
            <div class="modal-footer">

                {!! Form::submit('Save', ['class' => 'btn btn-primary', 'title' => 'Save']) !!}
            </div>

            {!! Form::close() !!}

        </div>
    </div>
</div>
@endsection