    @forelse ($menus as $menu) 
        <?php $checked = false;  ?>
        <?php if (isset($staffPermissions)) {
				//$checked = in_array($menu['id'], $menuIds);
        	  }
        ?>       
        <div class="col-sm-12 mrgn-btm-20">            
                <ul class="parent">   
                    <div class="checkbox">             
                        {!! Form::checkbox("menu[$menu[id]]",null,$checked,['id'=>"menu[$menu[id]]",'class'=>'menu']); !!}
                        {!! Form::label("menu[$menu[id]]", "$menu[menu]") !!}
                    </div>
                    <li>  
                        @forelse ($menu['permissions'] as $permission) 
                            <?php $permchecked = false; ?>
                            <?php if (isset($staffPermissions)) {
                                    $permchecked = in_array($permission['id'], $staffPermissions);
                                  }                            
                            ?> 
                            <div class="checkbox">
                                {!! Form::checkbox("permission[$permission[id]]",null,$permchecked,['id'=>"permission[$permission[id]]",'class'=>'permission']); !!} 
                                {!! Form::label("permission[$permission[id]]", permission($permission['permission'] ) ) !!}
                            </div>
                        @empty
                        <div class="col-sm-12 mrgn-btm-20">No Permissions</div>
                        @endforelse 
                    </li>                
                </ul>  
        </div>
    @empty
        <div class="col-sm-12 mrgn-btm-20">No Permissions</div>
    @endforelse  