@extends('layouts.layout3')

@section('content')
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
     
     <h1>Questions about your health issue, please click link below</h1>
    </section>
      
    <!-- Main content -->
    <section class="content">
        <div class="clearfix"></div>
                <div class="table-responsive"> 
        <table class="table">
            <thead>
                <tr>
                    <th >Question Set Name</th>
                    <th>Received On</th>
                    <th>Physician</th>
                    <th>Clinic</th>
                    <th>Contact</th>
                </tr>
            </thead>
           <!--  <tbody>
                <tr>
                    <td>
                        <p class="txt-blue"><a href="{{ url('patient/questionSetBrief') }}">Flank Pain Question Set</a></p>
                    
                    </td>
                    <td>10/11/2016</td>
                    <td>Dr. Fedrick Peter</td>
                    <td>Center for Medical Science</td>
                    <td>+(541) 754-3010</td>
                </tr>
                
                        <p class="txt-blue"><a href=""></a>Scrotal Pain Question Se</p>
                    
                    </td>
                    <td>10/11/2016</td>
                    <td>Dr. Peter Sam</td>
                    <td>Center for Medical Science</td>
                    <td>+(541) 754-3010</td>
                </tr>
                
            </tbody> -->
        </table>
    </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection