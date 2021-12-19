    <?php $__empty_1 = true; $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> 
        <?php $checked = false;  ?>
        <?php if (isset($staffPermissions)) {
				//$checked = in_array($menu['id'], $menuIds);
        	  }
        ?>       
        <div class="col-sm-12 mrgn-btm-20">            
                <ul class="parent">   
                    <div class="checkbox">             
                        <?php echo Form::checkbox("menu[$menu[id]]",null,$checked,['id'=>"menu[$menu[id]]",'class'=>'menu']);; ?>

                        <?php echo Form::label("menu[$menu[id]]", "$menu[menu]"); ?>

                    </div>
                    <li>  
                        <?php $__empty_2 = true; $__currentLoopData = $menu['permissions']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?> 
                            <?php $permchecked = false; ?>
                            <?php if (isset($staffPermissions)) {
                                    $permchecked = in_array($permission['id'], $staffPermissions);
                                  }                            
                            ?> 
                            <div class="checkbox">
                                <?php echo Form::checkbox("permission[$permission[id]]",null,$permchecked,['id'=>"permission[$permission[id]]",'class'=>'permission']);; ?> 
                                <?php echo Form::label("permission[$permission[id]]", permission($permission['permission'] ) ); ?>

                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                        <div class="col-sm-12 mrgn-btm-20">No Permissions</div>
                        <?php endif; ?> 
                    </li>                
                </ul>  
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="col-sm-12 mrgn-btm-20">No Permissions</div>
    <?php endif; ?>  