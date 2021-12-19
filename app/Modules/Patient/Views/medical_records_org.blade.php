@extends('layouts.layout3')

@section('content')
<!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>Medical Records</h1> </section>
            <!-- Main content -->
            <section class="content">
              
                <!--- ------ ------>
                            <div class="content-sub mrgn-btm-20 pdng-0">
            
            <div class="content-sub-heading"> 
               
               <div class="col-sm-12"><b>Allergies</b></div>
                <div class="clearfix"></div>
            </div>
            
            
            <div class="content-area-sub">
            
                 <div class="col-sm-12 mrgn-btm-20"><div class="checkbox">
                        <input id="checkbox2" type="checkbox">
                        <label for="checkbox2">
                            Penicillin
                        </label>
                    </div>
                    </div>
                
                 <div class="col-sm-12 mrgn-btm-20"><div class="checkbox">
                        <input id="checkbox3" type="checkbox">
                        <label for="checkbox3">
                            Sulfa
                        </label>
                    </div>
                    </div>
                
                 <div class="col-sm-12 mrgn-btm-20"><div class="checkbox">
                        <input id="checkbox4" type="checkbox">
                        <label for="checkbox4">
                            Latex
                        </label>
                    </div>
                    </div>
                
                <div class="col-sm-12 mrgn-btm-20"><div class="checkbox">
                        <input id="checkbox5" type="checkbox">
                        <label for="checkbox5">
                            Others
                        </label>
                    </div>
                    </div>
                <div class="col-sm-12 mrgn-btm-20">
                        
                    <textarea class="form-control" placeholder="Other Comments "></textarea>
                    
                    </div>
               
            </div>
            
         
        </div>
                <!--- ------ ------>
                  

                
                <!--- ------ --------- ---------- ------->
                <div class="content-sub mrgn-btm-20 pdng-0">
            
            <div class="content-sub-heading"> 
               
               <div class="col-sm-12"><b>Past Medical History</b></div>
                <div class="clearfix"></div>
            </div>
            
            
            <div class="content-area-sub">
            
                 <div class="col-sm-12 mrgn-btm-20"><div class="checkbox">
                        <input id="checkbox2" type="checkbox">
                        <label for="checkbox2">
                            High Blood Pressure
                        </label>
                    </div>
                    </div>
                
                 <div class="col-sm-12 mrgn-btm-20"><div class="checkbox">
                        <input id="checkbox3" type="checkbox">
                        <label for="checkbox3">
                            Low Blood Pressure
                        </label>
                    </div>
                    </div>
                
                 <div class="col-sm-12 mrgn-btm-20"><div class="checkbox">
                        <input id="checkbox4" type="checkbox">
                        <label for="checkbox4">
                            Diabetes
                        </label>
                    </div>
                    </div>
                
                <div class="col-sm-12 mrgn-btm-20"><div class="checkbox">
                        <input id="checkbox5" type="checkbox">
                        <label for="checkbox5">
                            Lung Diseases
                        </label>
                    </div>
                    </div>
                 <div class="col-sm-12 mrgn-btm-20"><div class="checkbox">
                        <input id="checkbox5" type="checkbox">
                        <label for="checkbox5">
                           Liver Diseases
                        </label>
                    </div>
                    </div>
                 <div class="col-sm-12 mrgn-btm-20"><div class="checkbox">
                        <input id="checkbox5" type="checkbox">
                        <label for="checkbox5">
                            Kidney Diseases
                        </label>
                    </div>
                    </div>
                <div class="col-sm-12 mrgn-btm-20"><div class="checkbox">
                        <input id="checkbox5" type="checkbox">
                        <label for="checkbox5">
                           Nuerological Problems
                        </label>
                    </div>
                    </div>
                <div class="col-sm-12 mrgn-btm-20"><div class="checkbox">
                        <input id="checkbox5" type="checkbox">
                        <label for="checkbox5">
                            Thyroid
                        </label>
                    </div>
                    </div>
                    </div>
                </div>
                   <!-- ------------- -->
                <div class="clearfix"></div>
                <div class="row">
                    <div class="col-md-9"><h4>Surgical History</h4></div>
                <div class="col-md-3"><button type="button" class="btn btn-third mrgn-btm-15 pull-right"><i class="fa fa-plus-square-o"></i> Add New</button></div>
                </div>
                         <div class="table-responsive mrgn-btm-20"> 
        <table class="table">
            <thead>
                <tr>
                    <th>Surgery</th>
                    <th>Date<i class="fa fa-angle-up pdng-lft-10" aria-hidden="true"></i></th>
                    <th ></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <p>Appendectomy</p>
                    
                    </td>
                    <td>10/22/2015</td>
                    <td></td>
                    <td></td>
                    <td>
                        <a href="#" class="edit pull-right " type="button" class="btn" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash-o delete_edit_fa" ></i></a>
                        <a href="#" class="edit pull-right mrgn-rgt-25" type="button" class="btn" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil-square-o delete_edit_fa"></i></a>
                   
                    </td>
                    
                </tr>
                
                <tr>
                    <td>
                        <p>TURP</p>
                    
                    </td>
                    <td>10/22/2015</td>
                    <td></td>
                    <td></td>
                    <td>
                    <a href="#" class="edit pull-right " type="button" class="btn" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash-o delete_edit_fa" ></i></a>
                        <a href="#" class="edit pull-right mrgn-rgt-25" type="button" class="btn" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil-square-o delete_edit_fa"></i></a>
                    </td>
                </tr>
                
            </tbody>
        </table>
    </div>
  <!-- ------------- -->
                
                      <div class="clearfix"></div>
                <div class="row">
                    <div class="col-md-9"><h4>Family History</h4></div>
                <div class="col-md-3"><button type="button" class="btn btn-third mrgn-btm-15 pull-right"><i class="fa fa-plus-square-o"></i> Add New</button></div>
                </div>
                         <div class="table-responsive mrgn-btm-20"> 
        <table class="table">
            <thead>
                <tr>
                    <th>Illness</th>
                    <th>Date<i class="fa fa-angle-up pdng-lft-10" aria-hidden="true"></i></th>
                    <th >Relation</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <p>Hypertension</p>
                    
                    </td>
                    <td>10/22/2015</td>
                    <td>Father</td>
                    <td></td>
                    <td>
                        <a href="#" class="edit pull-right " type="button" class="btn" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash-o delete_edit_fa" ></i></a>
                        <a href="#" class="edit pull-right mrgn-rgt-25" type="button" class="btn" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil-square-o delete_edit_fa"></i></a>
                   
                    </td>
                </tr>
                <tr>
                    <td>
                        <p>GERD</p>
                    
                    </td>
                    <td>10/22/2015</td>
                    <td>Mother</td>
                    <td></td>
                    <td>
                    <a href="#" class="edit pull-right" type="button" class="btn" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-trash-o" ></i></a>
                    <a href="#" class="edit pull-right mrgn-rgt-25" type="button" class="btn" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil-square-o delete_edit_fa"></i></a>
                    </td>
                </tr>
                
            </tbody>
        </table>
    </div>    
                <!-- ---   --->
                                            <div class="content-sub mrgn-btm-20 pdng-0">
            
            <div class="content-sub-heading"> 
               
               <div class="col-sm-12"><b>Social History</b></div>
                <div class="clearfix"></div>
            </div>
            
            
            <div class="content-area-sub">
            
                   <div class="row mrgn-btm-20 mrgn-0">
                       
                   <div class="col-md-3 col-xs-12"><p class="gender">Do you smoke?</p></div>
                    <div class="col-md-1 radio radio-info radio-inline">
                        <input type="radio" id="inlineRadio1" value="option1" name="radioInline" checked="">
                        <label for="inlineRadio1"> Male </label>
                    </div>
                    <div class="col-md-1 radio radio-inline">
                        <input type="radio" id="inlineRadio2" value="option1" name="radioInline">
                        <label for="inlineRadio2"> Female </label>
                    </div>
                    </div>
                   <div class="row mrgn-btm-20 mrgn-0">
                       
                   <div class="col-md-3 col-xs-12"><p class="gender">Do you drink alcohol?</p></div>
                    <div class="col-md-1 radio radio-info radio-inline">
                        <input type="radio" id="inlineRadio3" value="option1" name="radioInline" checked="">
                        <label for="inlineRadio3"> Male </label>
                    </div>
                    <div class="col-md-1 radio radio-inline">
                        <input type="radio" id="inlineRadio4" value="option1" name="radioInline">
                        <label for="inlineRadio4"> Female </label>
                    </div>
                    </div>
                   <div class="row mrgn-btm-20 mrgn-0">
                       
                   <div class="col-md-3 col-xs-12"><p class="gender">Do you take drugs?</p></div>
                    <div class="col-md-1 radio radio-info radio-inline">
                        <input type="radio" id="inlineRadio5" value="option1" name="radioInline" checked="">
                        <label for="inlineRadio5"> Male </label>
                    </div>
                    <div class="col-md-1 radio radio-inline">
                        <input type="radio" id="inlineRadio6" value="option1" name="radioInline">
                        <label for="inlineRadio6"> Female </label>
                    </div>
                    </div>
                
                
                
                
             
                <div class="col-sm-12 mrgn-btm-20">
                        
                        <textarea class="form-control" placeholder="Other Comments "></textarea>
                    
                    </div>
               
            </div>
            
         
        </div>
                <div class="btn-wrap"><button type="button" class="btn btn-primary mrgn-lft-15">Save</button></div>
                
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
@endsection