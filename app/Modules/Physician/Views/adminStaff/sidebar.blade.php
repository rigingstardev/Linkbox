
    <!-- Sidebar Menu -->
    <ul class="sidebar-menu">
        
    	@if(count($menusAry))
    		@foreach($menusAry as $key => $menu)
    			@if($menu['id'] == 1 && in_array(1,$permissionIds))
    				<!-- Optionally, you can add icons to the links -->
			        <li class="{{ (physicianClassActive() == 'menu_question_set') ? 'active' : ''}}">
		                @if(subscribed())          
		                    <a href="{{url('/physician/home')}}">
		                @else 
		                    <a href="{{url('/physician/questionSet')}}">
		                @endif               
	                    <!-- <i class="fa fa-question-circle"></i> <span>Question Sets ({{\Session::get('physician_id')}})</span> -->
	                    <i class="fa fa-question-circle"></i> <span>Question Sets</span>
	                    </a>
			        </li>
			      
    			@elseif($menu['id'] == 2 && in_array(2,$permissionIds))
			        <li class="{{ (physicianClassActive() == 'menu_patients') ? 'active' : ''}}">
			            <a href="{!! route('physician.patient.index') !!}">
			                <i class="fa fa-user"></i> <span>Patients</span>
			            </a> 
			        </li>
			    @elseif($menu['id'] == 3 && in_array(7,$permissionIds))
			        <li class="{{ (physicianClassActive() == 'menu_adminstaff') ? 'active' : ''}}">  
			            <a href="{!! route('physician.adminstaff.index') !!}">
			                <i><img src="{{asset('assets/physician/images/admin-staff.png')}}"/></i> <span>Administrative Staff</span>
			            </a>
			        </li>
    			@endif
    		@endforeach
    	@endif
    </ul>
    <!-- /.sidebar-menu -->