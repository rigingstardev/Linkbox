@extends('layouts.layout2')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

        <h1>Flank Pain Question Set</h1>
    </section>



    <!-- Main content -->
    <form action="{{url('physician/postPatientQuestionSetDetail')}}" method="post">
        <section class="content content-library">
            <div class="content-library-bg"></div>
            <div class="content-sub total_display mrgn-btm-20">
                <div class="total"> Total
                    <br><span>4</span> </div>
                <div class="answered"> Answered
                    <br><span>3</span> </div>
                <div class="unanswered"> Unanswered
                    <br><span>1</span> </div>
            </div><div class="clearfix"></div>
            <h4 class="pull-left">Questions <span class="txt-blue">4</span></h4>
            <section class="content-sub-header">



                <div class="col-xs-12 col-sm-5 col-md-4 col-lg-2 pull-right">
                    <div class="row">   

                    </div></div>
            </section>

            <div class="content-sub mrgn-btm-20 pdng-0">
                <div class="content-sub-heading"> 
                    <div class="col-sm-12">
                        <b>Flank Pain</b>

                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="content-area-sub">
                    <div class="col-sm-12">
                        <p>This question set will help us know more about your illness.</p>
                    </div>
                </div>
            </div>

            <div class="content-sub mrgn-btm-20 pdng-0">
                <div class="content-sub-heading"> 
                    <div class="col-sm-12">
                        <b>Onset/Duration Questions</b>

                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="content-area-sub">
                    <div class="col-sm-12 mrgn-btm-25">


                        <p>1. When did Flank Pain begin?</p>

                        <div class="radio radio-info question-calendar">
                            <input type="radio" id="inlineRadio1" value="option1" name="radioInline" checked="">
                            <label for="inlineRadio1" class="datepicker-control">


                                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3 input-group">
                                    <input type="text" required="" class="date-picker form-control">
                                    <span class="input-group-addon calendar-icn-bg"><i class="fa fa-calendar icon-calendar"></i></span>
                                </div>

                            </label>
                        </div>

                        <div class="radio">
                            <input type="radio" id="inlineRadio2" value="option1" name="radioInline">
                            <label for="inlineRadio2"> Approximate Time Frame </label>
                            <div class="clearfix"></div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-3 time-set pdng-0">
                                <div class="col-sm-6 time-set-hrs"><select id="basic" class="selectpicker show-tick">
                                        <option>10</option>
                                        <option>9</option>
                                        <option>8</option>
                                        <option>7</option>
                                    </select></div>

                                <div class="col-sm-6 time-set-min"><select id="basic" class="selectpicker show-tick">
                                        <option>Minutes</option>
                                        <option>9</option>
                                        <option>8</option>
                                        <option>7</option>
                                    </select></div>
                            </div>
                        </div>

                        <span class="ago pull-left pdng-lft-15 pdng-tp-3">Ago</span>  

                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>

            <div class="content-sub mrgn-btm-20 pdng-0">
                <div class="content-sub-heading">
                    <div class="col-sm-12">
                        <b>Body Location Questions</b>

                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="content-area-sub">
                    <div class="col-sm-12 mrgn-btm-25">
                        <label class="lbl-clinic">Clinical Question</label>
                        <p class="mrgn-btm-15">2. Where exactly is the Flank Pain located?</p>

                        <div class="col-sm-3 pdng-0">
                            <input class="form-control">
                        </div>

                    </div>
                </div>
            </div>

            <div class="content-sub mrgn-btm-20 pdng-0">
                <div class="content-sub-heading">
                    <div class="col-sm-12">
                        <b>Quantity Questions</b>

                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="content-area-sub">
                    <div class="col-sm-12 mrgn-btm-25">

                        <p class="mrgn-btm-15">3. How would you like to rate your sickness level?</p>

                        <div class="col-sm-1 pdng-0">
                            <select id="basic" class="selectpicker show-tick form-control">
                                <option>10</option>
                                <option>9</option>
                                <option>8</option>
                                <option>7</option>
                            </select>
                        </div>

                    </div>
                </div>
            </div>

            <div class="content-sub mrgn-btm-20 pdng-0">

                <div class="content-sub-heading"> 

                    <div class="col-sm-12"><b>Aggravating Questions</b></div>
                    <div class="clearfix"></div>
                </div>


                <div class="content-area-sub">

                    <div class="col-sm-12 mrgn-btm-15">
                        <label class="lbl-clinic">Clinical Question</label>
                        <p>4. Does anything make the  Flank Pain worse?</p>


                    </div>
                    <div class="col-sm-12 mrgn-btm-20"><div class="checkbox">
                            <input id="checkbox2" type="checkbox">
                            <label for="checkbox2">
                                Running
                            </label>
                        </div>
                    </div>

                    <div class="col-sm-12 mrgn-btm-20"><div class="checkbox">
                            <input id="checkbox3" type="checkbox">
                            <label for="checkbox3">
                                Jumping
                            </label>
                        </div>
                    </div>

                    <div class="col-sm-12 mrgn-btm-20"><div class="checkbox">
                            <input id="checkbox4" type="checkbox">
                            <label for="checkbox4">
                                Standing
                            </label>
                        </div>
                    </div>

                    <div class="col-sm-12 mrgn-btm-20"><div class="checkbox">
                            <input id="checkbox5" type="checkbox">
                            <label for="checkbox5">
                                Eating
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="btn-wrap">
                <button type="submit" class="btn btn-primary mrgn-lft-15">Done</button>
                <button type="button" class="btn btn-default mrgn-lft-15" onclick="location.href = '{{url('physician/patientDetails')}}'">Cancel</button>
            </div>


        </section>
    </form>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection