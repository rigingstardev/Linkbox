<aside class="main-sidebar">
    <?php
    use App\Modules\Physician\Models\PermissionUser;
    use App\User;
    $physicianIds = PermissionUser::where(['user_id' => Auth::user()->id])->pluck('physician_id')->toArray(); 

    if(Auth::user()->practice_id > 0)
    {
        $physicianDetails = User::whereIn('id',$physicianIds)->where('practice_id',Auth::user()->practice_id)->get()->toArray();
    }
    else
    {
        $physicianDetails = [];
    }
    ?>

    @if(Auth::user()->user_role == 'S')
        <?php
        $paysicianid = 0;
        if(\Session::has('physician_id'))
        {
            $paysicianid = \Session::get('physician_id');
        }
        ?>
        <select name="physicianlist" id="physicianlist" class="form-control">
            <option <?php 
            echo ($paysicianid == 0?"selected":"")
            ?> value="">Select Physician</option>
            @if(count($physicianDetails))
                @foreach($physicianDetails as $key => $detail)
                    <option <?php 
            echo ($paysicianid == $detail['id']?"selected":"")
            ?> value="{{$detail['id']}}">{{$detail['name']}}</option>
                @endforeach
            @endif
        </select>
        <section id="sidebarHtml" class="sidebar">
        </section>
        
        <!-- /.sidebar -->
    @else
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar Menu -->
            <ul class="sidebar-menu">
                <!-- Optionally, you can add icons to the links -->
                <li class="{{ (physicianClassActive() == 'menu_question_set') ? 'active' : ''}}">
                 
                @if(hasPermission('questionset_list'))   
                    
                
                        @if(subscribed())        
                            <a href="{{url('/physician/home')}}">
                        @else 
                            <a href="{{url('/physician/questionSet')}}">
                        @endif               
                            <i class="fa fa-question-circle"></i> <span>Question Sets</span>
                            </a>
                    @endif
                </li>
                <li class="{{ (physicianClassActive() == 'menu_patients') ? 'active' : ''}}">
                    @if(hasPermission('patient_list')) 
                    <a href="{!! route('physician.patient.index') !!}">
                        <i class="fa fa-user"></i> <span>Patients</span>
                    </a>
                    @endif 
                </li>                  
                <li class="{{ (physicianClassActive() == 'menu_adminstaff') ? 'active' : ''}}">
                    @if(hasPermission('admin_staff_list'))     
                    <a href="{!! route('physician.adminstaff.index') !!}">
                        <i><img src="{{asset('assets/physician/images/admin-staff.png')}}"/></i> <span>Administrative Staff</span>
                    </a>
                    @endif  
                </li>                     
                <li class="{{ (physicianClassActive() == 'menu_notifications') ? 'active' : ''}}">
                    @if(hasPermission())
                    <a href="{{ url('physician/listNotifications') }}">
                       <i class="fa fa-bell"></i> <span>Notifications   <label class="label label-success" id="notifCount"></label>  </span> 
                    </a>
                    @endif 
                </li>

                <li class="treeview {{ (physicianClassActive() == 'menu_profile' || physicianClassActive() == 'menu_subscription') ? 'active' : ''}}">
                    @if(hasPermission())
                    <a href="#">
                        <i><img src="{{asset('assets/physician/images/acc-details.png')}}"/></i> <span>Account Details</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-down pull-right"></i>
                        </span>
                    </a>
                    @endif 
                    <ul class="treeview-menu  menu-open">
                        @if(hasPermission())
                        <li class="{{ (physicianClassActive() == 'menu_profile') ? 'active' : ''}}">
                            <a href="{{ url('physician/profile') }}">
                                <i><img src="{{asset('assets/physician/images/profile-details.png')}}"/></i> Profile Details
                            </a>
                        </li>
                        @endif 
                        <li class="{{ (physicianClassActive() == 'menu_subscription') ? 'active' : ''}}">
                            @if(hasPermission())
                            <a href="{{ url('physician/subscription') }}">
                                <i><img src="{{asset('assets/physician/images/subscription.png')}}"/></i> Subscription Details
                            </a>
                            @endif 
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- /.sidebar-menu -->
        </section>
    @endif
</aside>
