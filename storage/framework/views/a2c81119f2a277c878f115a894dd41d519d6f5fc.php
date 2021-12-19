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

    <?php if(Auth::user()->user_role == 'S'): ?>
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
            <?php if(count($physicianDetails)): ?>
                <?php $__currentLoopData = $physicianDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option <?php 
            echo ($paysicianid == $detail['id']?"selected":"")
            ?> value="<?php echo e($detail['id']); ?>"><?php echo e($detail['name']); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </select>
        <section id="sidebarHtml" class="sidebar">
        </section>
        
        <!-- /.sidebar -->
    <?php else: ?>
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar Menu -->
            <ul class="sidebar-menu">
                <!-- Optionally, you can add icons to the links -->
                <li class="<?php echo e((physicianClassActive() == 'menu_question_set') ? 'active' : ''); ?>">
                 
                <?php if(hasPermission('questionset_list')): ?>   
                    
                
                        <?php if(subscribed()): ?>        
                            <a href="<?php echo e(url('/physician/home')); ?>">
                        <?php else: ?> 
                            <a href="<?php echo e(url('/physician/questionSet')); ?>">
                        <?php endif; ?>               
                            <i class="fa fa-question-circle"></i> <span>Question Sets</span>
                            </a>
                    <?php endif; ?>
                </li>
                <li class="<?php echo e((physicianClassActive() == 'menu_patients') ? 'active' : ''); ?>">
                    <?php if(hasPermission('patient_list')): ?> 
                    <a href="<?php echo route('physician.patient.index'); ?>">
                        <i class="fa fa-user"></i> <span>Patients</span>
                    </a>
                    <?php endif; ?> 
                </li>                  
                <li class="<?php echo e((physicianClassActive() == 'menu_adminstaff') ? 'active' : ''); ?>">
                    <?php if(hasPermission('admin_staff_list')): ?>     
                    <a href="<?php echo route('physician.adminstaff.index'); ?>">
                        <i><img src="<?php echo e(asset('assets/physician/images/admin-staff.png')); ?>"/></i> <span>Administrative Staff</span>
                    </a>
                    <?php endif; ?>  
                </li>                     
                <li class="<?php echo e((physicianClassActive() == 'menu_notifications') ? 'active' : ''); ?>">
                    <?php if(hasPermission()): ?>
                    <a href="<?php echo e(url('physician/listNotifications')); ?>">
                       <i class="fa fa-bell"></i> <span>Notifications   <label class="label label-success" id="notifCount"></label>  </span> 
                    </a>
                    <?php endif; ?> 
                </li>

                <li class="treeview <?php echo e((physicianClassActive() == 'menu_profile' || physicianClassActive() == 'menu_subscription') ? 'active' : ''); ?>">
                    <?php if(hasPermission()): ?>
                    <a href="#">
                        <i><img src="<?php echo e(asset('assets/physician/images/acc-details.png')); ?>"/></i> <span>Account Details</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-down pull-right"></i>
                        </span>
                    </a>
                    <?php endif; ?> 
                    <ul class="treeview-menu  menu-open">
                        <?php if(hasPermission()): ?>
                        <li class="<?php echo e((physicianClassActive() == 'menu_profile') ? 'active' : ''); ?>">
                            <a href="<?php echo e(url('physician/profile')); ?>">
                                <i><img src="<?php echo e(asset('assets/physician/images/profile-details.png')); ?>"/></i> Profile Details
                            </a>
                        </li>
                        <?php endif; ?> 
                        <li class="<?php echo e((physicianClassActive() == 'menu_subscription') ? 'active' : ''); ?>">
                            <?php if(hasPermission()): ?>
                            <a href="<?php echo e(url('physician/subscription')); ?>">
                                <i><img src="<?php echo e(asset('assets/physician/images/subscription.png')); ?>"/></i> Subscription Details
                            </a>
                            <?php endif; ?> 
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- /.sidebar-menu -->
        </section>
    <?php endif; ?>
</aside>
