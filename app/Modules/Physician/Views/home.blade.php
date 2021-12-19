@extends('layouts.layout2')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">

      <h1>All Question Sets</h1>
   </section>



   <!-- Main content -->
   <section class="content">
      @include('layouts.show_alert_message')
      <div id="div-alert" ></div>
      <section class="content-sub-header">

         <div class="col-xs-12 col-sm-6 col-md-5 col-lg-3 search-heading">
            <div class="row">
               <div id="imaginary_container">
                  <div class="input-group stylish-input-group">
                     <input type="text" class="form-control" id="search" name="search" placeholder="Search"  >
                     <span class="input-group-addon " >
                        <button title="Search" id="searchlist">
                           <span class="glyphicon glyphicon-search"></span>
                        </button>
                     </span>
                  </div>
               </div>
            </div>
         </div>   
          @if(Auth::user()->user_role == 'S')
          <div class="clearfix"></div>
          @endif
         <div class="col-xs-12 col-sm-5 col-md-4 col-lg-2 pull-right">
            <div class="row mrgn-btm-15">               
               <?php $permEditCls = (hasPermission()) ? '' : 'nopermission'; ?>
               @if (hasPermission())
               <a href="{{url('physician/createQuestionSet')}}">
                  <button type="button" class="btn btn-third btn-block" title="Create Question Set">
                     <i class="fa fa-plus-square-o"></i> Create Question Set
                  </button>
               </a>
               @endif
            </div>
         </div>
         <div class="clearfix"></div>
      </section>
      <div class="clearfix"></div>

      <div class="table-responsive">
         <?php /* @if(count($questionSets) > 0) */ ?>
         <table class="table" id="question-sets">
            <thead>
               <tr>
                  <th>Question Set Name</th>
                  <th>Modified</th>
                  <th>@if (hasPermission()) Edit @endif</th>
                  <th></th>                  
                  <th></th>                  
                  <th></th>
                  <th></th>
                  <th></th>
               </tr>
            </thead>
            <?php /*  <tbody>
              @foreach ($questionSets as $set)
              <tr>
              <td>
              <a href="{{url('physician/question-set-detail/'.$set->id)}}"  class="txt-blue {!! $permCls !!}">{{$set->title}} Question Set</a>
              <p class="txt-sm">Created {{convertDateToMMDDYYYY($set->created_at)}}</p>
              </td>
              <td>{{ convertDateToMMDDYYYY($set->updated_at) }}</td>
              <td><a href="{{url('physician/question-set-detail/'.$set->id.'/edit')}}" class="edit {!! $permCls !!}" title="Edit" ><i class="fa fa-pencil-square-o" ></i></a></td>
              <td><span class="label @if($set->visibility == 'private'){{'label-private' }}@else {{'label-public'}}@endif ">{{ ucwords($set->visibility)}}</span></td>
              <td><a href="{{url('physician/sendQuestionSet/'.$set->id)}}" class="{!! $permCls !!}"><button type="button" class="btn btn-default read-more" id="">Send</button></a>

              <!--<td><button type="button" class="btn btn-default read-more" id="" title="Send" >Send</button>-->
              </td>
              </tr>
              @endforeach
              </tbody> */ ?>
         </table>
         <?php /* @else
           <div class="col-xs-12 mrgn-btm-15 mrgn-tp-15">
           <b>{{trans('custom.no_questions_found')}}</b>
           </div>
           @endif */ ?>
      </div>

   </section>
   <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!-- The Modal -->
<div class="modal fade" id="testPreviewModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form id="setPreviewQuestions">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Please select the required fields</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          
          <!-- Modal body -->
          <div class="modal-body min-height-100">
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="inputEmail4">Age</label>
                <input type="text" name="age"  class="form-control" placeholder="Age" id="testPreviewAge">
                <span id="errAge"></span>
              </div>
              <div class="form-group col-md-6">
                <label for="inputPassword4">Gender</label>
                <select class="form-control" name="gender" id="testPreviewGender">
                  <option value=''>Select</option>  
                  <option value='M'>Male</option>
                  <option value='F'>Female</option>
                </select>
                <span id="errGender"></span>
              </div>
                <input type="hidden" name="questionId" class="questionId" id="questionId">
            </div>
          </div>
          <!-- Modal footer -->
          <div class="modal-footer">
              <button type="cancel" class="btn btn-default" data-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-primary" id="sendDataValue">Send</button>
          </div>
        </form>
      </div>
    </div>
  </div>
<!-- Modal for Test Preivew Ends Here -->

@endsection
@section('page_scripts')
<script type="text/javascript">
    var columns = [
       {data: 'title', name: 'title', orderable: false, sortable: false, "width": "30%"},
       {data: 'modified', name: 'modified', orderable: false, sortable: false, "width": "15%"},
       {data: 'edit', name: 'edit', orderable: false, sortable: false, "width": "15%"},
       {data: 'testpreview', name: '', orderable: false, sortable: false, "width": "15%"},
       {data: 'visibility', name: '', orderable: false, sortable: false, "width": "12%"},
       {data: 'duplicate', name: '', orderable: false, sortable: false, "width": "13%"},
       {data: 'steps_completed', name: '', orderable: false, sortable: false, "width": "15%"},
       {data: 'delete', name: '', orderable: false, sortable: false, "width": "15%"}
    ];
    var parameters = [];
    parameters['tabId'] = 'question-sets';
    parameters['columns'] = columns;
    parameters['ajaxUrl'] = "{!! url('physician/get-question-sets') !!}";
    parameters['isPopup'] = true;
    $(document).ready(function () {
       listingTables(parameters);
    });
    $(document).on('click', '#searchlist', function () {
       if ($.trim($("#search").val()) != '')
          listingTables(parameters);
    })
    $("#search").on("keydown", function (event) {
       if (event.which == 13) {
          listingTables(parameters);
          event.preventDefault();
       }
    });
    $("#search").on("keyup", function (event) {
       if ($.trim($(this).val()) == '') {
          listingTables(parameters);
       }
    });
    $(document).on('click', '.clear-div', function () {
       setTimeout(function () {
          $('.'+params.errorClass).remove();
       }, 10);
    });
</script>
@endsection