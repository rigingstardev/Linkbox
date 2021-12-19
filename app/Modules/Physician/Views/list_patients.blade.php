@extends('layouts.layout2')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

        <h1>Patients</h1>
    </section>



    <!-- Main content -->
    <section class="content">

        <section class="content-sub-header mrgn-btm-15">

            <div class="col-xs-12 col-sm-6 col-md-5 col-lg-3 search-heading">
                <div class="row">   
                    <div id="imaginary_container"> 
                        <div class="input-group stylish-input-group">
                            <input type="text" class="form-control"  placeholder="Search Name" >
                            <span class="input-group-addon">
                                <button>
                                    <span class="glyphicon glyphicon-search"></span>
                                </button>  
                            </span>
                        </div>
                    </div>
                </div> 

            </div>
            <div class="clearfix"></div>
        </section>
        <div class="clearfix"></div>

        <div class="table-responsive"> 
            <table class="table">
                <thead>
                    <tr>
                        <th>Name<i class="fa fa-angle-up pdng-lft-10" aria-hidden="true"></i></th>
                        <th>Email</th>
                        <th>Date of Birth</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Contact Number</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 0; $i < 10; $i++)
                    <tr>
                        <td><a href="{{ url('physician/patientDetails') }}" class="txt-blue">Tom Peter</a></td>
                        <td>tompeter@gmail.com</td>
                        <td>10-05-1986</td>
                        <td>26</td>
                        <td>Male</td>
                        <td>(541) 754-3010</td>
                    </tr>
                    @endfor

                </tbody>
            </table>
        </div>

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection