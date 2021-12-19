<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <!-- Optionally, you can add icons to the links -->
            <li class="active">
            <li class="{{ (patientClassActive() == 'menu_question_set') ? 'active' : ''}}">
                <a href="{!! route('patient.question.received') !!}">
                    <i class="fa fa-question-circle"></i> <span>Question Sets</span>
                </a>
            </li>
            <li class="{{ (patientClassActive() == 'menu_profile') ? 'active' : ''}}">
                <a href="{{ url('patient/profile') }}"><i><img src="{{asset('assets/patient/images/icn-p-rof-detail.png')}}" ></i> <span>Profile Details</span>
                </a>
            </li>
            <li class="{{ (patientClassActive() == 'menu_medical_records') ? 'active' : ''}}">
                <a href="{{ url('patient/medicalRecords') }}"><i><img src="{{asset('assets/patient/images/icn-m-recrd.png')}}" /></i> <span>Medical Records</span>
                </a>
            </li>
            <li class="{{ (patientClassActive() == 'menu_notifications') ? 'active' : ''}}">
               <a href="{{ url('patient/notifications') }}"><i class="fa fa-bell"></i> <span>Notifications <label class="label label-success" id="notifCount"></label></span> 
                </a>
            </li>
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
