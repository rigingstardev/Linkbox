<?php
namespace App\Modules\Physician\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modules\Physician\Models\Permissions;
use App\Modules\Physician\Models\Menus;
use Vinkla\Hashids\Facades\Hashids;
use App\User;
// use Auth
use Illuminate\Support\Facades\Auth;
// use DB
use Illuminate\Support\Facades\DB;
// Repository
use App\Modules\Physician\Repositories\AdminStaffRepository;
use App\Modules\Physician\Repositories\PermissionUserRepository;
// Requests 
use App\Modules\Physician\Requests\AdminStaffCreateRequest;
use App\Modules\Physician\Requests\AdminStaffUpdateRequest;
use Yajra\DataTables\Facades\DataTables;
// Mail Sending
use Mail;
use App\Mail\AdminStaff;
use Illuminate\Notifications\Notifiable;
use App\Notifications\StaffNotify;

use App\Modules\Physician\Models\PermissionUser;
class AdminStaffController extends Controller {

    use Notifiable;

    /**
     * initilaize the constructure
     * @param  none
     * @return \Illuminate\Http\Response
     */
    public function __construct() {
        /*if(\Session::has('physician_id'))
        {
            $this->paysicianid = \Session::get('physician_id');
        }
        else
        {
            $this->paysicianid = 0;  
        }*/
        $this->middleware(function ($request, $next)
        {
            $this->paysicianid = \Session::get('physician_id');
            return $next($request);
        });
    }

      /**
     * Display patient registration form.
     *
     * @return Response
     */
    public function sidebar(Request $request,$physician_id)
    {   
        $htmlRes = "";
        if(isset($physician_id) && $physician_id > 0)
        { 
            \Session::put('physician_id',$physician_id);
            $permissionIds = PermissionUser::where("physician_id",$physician_id)->where("user_id",Auth::user()->id)->pluck('permission_id')->toArray();
          
            if(count($permissionIds))
            {
                $menusAry = Menus::with('permissions')->get()->toArray();
                if(count($menusAry))
                {             
                    // print_r($permissionIds); exit;
                    $returnHTML = view("Physician::adminStaff.sidebar")->with(['menusAry'=>$menusAry,'permissionIds'=>$permissionIds,'physician_id' => $physician_id])->render();
                    return response()->json(array('success' => true, 'html'=>$returnHTML));
                }
            }
        } 
        \Session::put('physician_id',0);
        return response()->json(array('success' => true, 'html'=>""));
    }


    /**
     * Listing of Admin Staff 
     * @param none
     * @return HTML
     */
    public function index() {   
       
        if (!(Auth::user()->isAuthorizedStaff('admin_staff_list')))
            return redirect()->back()->with('error', trans('Physician::messages.permission_error'));  

        return view("Physician::adminStaff.list");
    }

    /**
     * Ajax content for Listing 
     * @param $request
     * @param string $search
     * @return JSON Response
     */
    public function getList(Request $request, AdminStaffRepository $adminstaffrepo) { 
        $user_id = $this->paysicianid;
        $adminStaffs = $adminstaffrepo->all($user_id,$request);

        return Datatables::of($adminStaffs)
                        ->addColumn('', function($adminStaffs) {
                            $actionLinks = "";
                            if (Auth::user()->isAuthorizedStaff('admin_staff_edit'))
                                $actionLinks .= '<a href="' . route('physician.adminstaff.edit', $adminStaffs->id) . '" class="edit not-done" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil-square-o" ></i></a>';
                            if (Auth::user()->isAuthorizedStaff('admin_staff_delete'))
                                $actionLinks .= ' <a href="' . route('physician.adminstaff.delete', $adminStaffs->id) . '" data-id="' . $adminStaffs->id . '" class="edit mrgn-lft-25 not-done" data-toggle="tooltip" data-placement="top" title="Delete" onClick="return confirm(\'' . sprintf(trans('Physician::messages.delete_confirm'), 'Staff') . '\')"><i class="fa fa-trash-o" ></i></a>';
                            return $actionLinks;                         
                        })
                        /*->filter(function ($instance) use ($request) {
                            if ($request->has('search')) {
                                $searchText = $request->get('search');
                                $instance->where(function ($query) use ($searchText) {
                                    $query->orWhere('name', 'like', "%{$searchText}%")
                                    ->orWhere('email', 'like', "%{$searchText}%");
                                });
                            }
                        })*/
                        ->make(true);
    }

    /**
     * To Create New Administrator Staff   
     * @return HTML
     */
    public function getNew() {
        $menus = Menus::with('permissions')->get()->toArray();
        return view("Physician::adminStaff.create", compact('menus'));
    }

    /**
     * To Update New Administrator Staff
     * @param request AdminStaffCreateRequest
     * @param String $name, $email, $password 
     * @param Array $menu
     * @param Repository AdminStaffRepository
     * @return Response
     */
    public function postCreate(AdminStaffCreateRequest $request, AdminStaffRepository $adminstaffrepo) {

        $user_id = $this->paysicianid;
        $data = $request->all();
        $menuroles = $data['permission'];
        $data['practice_id'] = Auth::user()->practice_id;
        // $data['parent_id'] = '';
        // $data['parent_id'] = $user_id;
        $data['is_admin_staff'] = 'Y';
        $data['is_account_active'] = 'Y';
        unset($data['permission']);
        unset($data['menu']);
        $adminStaff = $adminstaffrepo->save($data);
        if ($adminStaff) {
            $menuroles = array_keys($menuroles);
            foreach ($menuroles as $menuVal) {
                $permissions[] = ['permission_id' => $menuVal, 'user_id' => $adminStaff->id, 'physician_id' => $user_id,'created_by'=>$user_id,'updated_by'=>$user_id,'created_at'=>date("Y-m-d H:i:s"),'updated_at'=>date("Y-m-d H:i:s")];
            }
            $adminstaffrepo->get()->permissions()->sync($permissions);
            $data['narrativetext'] = trans("Physician::messages.email_adminstaff_add_text");
            $data['action'] = 'CREATE';
            //$adminStaff->notify(new StaffNotify($data));
        }
        \Session::flash('success', sprintf(trans('Physician::messages.success_reg'), 'Staff'));
        return json_encode(array('success' => true, 'message' => sprintf(trans('Physician::messages.success_reg'), 'Staff'), 'redirectUrl' => route('physician.adminstaff.index')));
    }

    /**
     * To Edit Administrator Staff
     * 
     * @return HTML
     */
    public function getEdit(Request $request, AdminStaffRepository $adminstaffrepo, PermissionUserRepository $permissionUserRepo) {
        
        $user_id = $request->user_id;
        if (!(Auth::user()->isAuthorizedStaff('admin_staff_edit')))
            return redirect()->back()->with('error', trans('Physician::messages.permission_error'));  

        $authUser = $this->paysicianid;
        $adminStaff = $adminstaffrepo->get()->AdminStaff()->with('permissions')->where('id', $user_id)->get()->toArray();

        // echo '<pre>';print_r($user_id); exit;
        // $adminStaff = $adminstaffrepo->get()->AdminStaff()->with('permissions')->where('id', $user_id)->get();

        // echo '<pre>';print_r($adminStaff); exit;
        $adminStaff = end($adminStaff); 
        //echo '<pre>';print_r($adminStaff);
        /*if (($authUser != $adminStaff['parent_id']) || empty($adminStaff))
        return redirect()->back()->with('error', trans('Physician::messages.unauthorized'));*/
        /*
        $isParent = PermissionUser::where(['permission_id' => 8,'user_id' => $request->user_id, 'physician_id' => $authUser])->first();
        if (!$isParent) {
            return redirect()->back()->with('error', trans('Physician::messages.unauthorized'));
        }*/
        $staffPermissions = PermissionUser::where(['user_id' => $user_id, 'physician_id' => Auth::user()->id])->pluck('permission_id')->toArray();
        
        $menus = Menus::with('permissions')->get()->toArray();
        // echo 'menus';
        // echo '<pre>';print_r($menus);

        $menuIds = array_pluck($adminStaff['permissions'], 'menu_id');
        //echo '------------';
        //echo 'ids';
        //echo '<pre>';print_r($menuIds);
        //$staffPermissions = array_pluck($adminStaff['permissions'], 'id');
        //echo '------------';
        //echo 'permission';
        //echo '<pre>';print_r($staffPermissions); exit;
        return view("Physician::adminStaff.edit", compact('menus', 'adminStaff', 'staffPermissions', 'menuIds'));
    }

    /**
     * To Update Administrator Staff   
     * @param request AdminStaffUpdateRequest
     * @param String $name, $email, $password 
     * @param Array $menu
     * @param Repository AdminStaffRepository       
     * @return Response
     */
    public function postUpdate(AdminStaffUpdateRequest $request) {
// echo"in";exit;
        $user = User::find($request->id);        
        $user->name = $request->name;
        $user->email = $request->email;
        $currentPwd = $user->password;
        if (isset($request->password) && $request->password != "") {
            $user->password = \Hash::make($request->password);
        }
        $user->save();
      
        //Delete Permission First
        
        $adminStaffPermissions = array_keys($request['permission']);
// echo "<pre>"; print_r($adminStaffPermissions); exit;
        //$user->permissions()->sync($adminStaffPermissions);
        PermissionUser::where(['user_id' => $request->id,'physician_id' => $this->paysicianid])->delete();

        if(count($adminStaffPermissions))
        {
            foreach ($adminStaffPermissions as $permissionid) {
                $permissions[] = ['permission_id' => $permissionid, 'user_id' => $request->id, 'physician_id' => $this->paysicianid,'created_by'=>$this->paysicianid,'updated_by'=>$this->paysicianid,'created_at'=>date("Y-m-d H:i:s"),'updated_at'=>date("Y-m-d H:i:s")];
            }
            // print_r($permissions); exit;
            
            PermissionUser::insert($permissions);
        }

        \Session::flash('success', sprintf(trans('Physician::messages.success_update'), 'Staff'));
        if (isset($request->password) && $request->password != "") {
            if (!(\Hash::check($request->password, $currentPwd))) {
                $data = $request->all();
                $data['narrativetext'] = trans("Physician::messages.email_adminstaff_edit_text");
                $data['action'] = 'UPDATE';
                $user->notify(new StaffNotify($data));
            }
        }       
        return json_encode(array('success' => true, 'message' => sprintf(trans('Physician::messages.success_update'), 'Staff'), 'redirectUrl' => route('physician.adminstaff.index')));
    }
    /**
     * To Delete Administrator Staff
     * @param Integer $user_id 
     * @param Repository PermissionUserRepository  
     * @return Response
     */
    public function getDelete(Request $request, PermissionUserRepository $permissionUserRepo) {       
        
        if (!(Auth::user()->isAuthorizedStaff('admin_staff_delete')))
            return redirect()->back()->with('error', trans('Physician::messages.permission_error'));  
        
        $authUser = $this->paysicianid;
        
        $adminStaff = PermissionUser::where('user_id', $request->user_id)->where('physician_id', $authUser)->first();

        if (($authUser != $adminStaff['physician_id']) || empty($adminStaff))
            return redirect()->back()->with('error', trans('Physician::messages.permission_error'));

        // To delete all Permissions
        $permissionUserRepo->get()->where('user_id', $request->user_id)->where('physician_id', $authUser)->delete();
        // To delete User       
        $adminStaff->delete();
        return redirect()->back()->with('success', sprintf(trans('Physician::messages.success_delete'), 'Staff'));
    }

    public function postAddStaffInPhysician(Request $request, AdminStaffRepository $adminstaffrepo, PermissionUserRepository $permissionUserRepo)
    {   
        $permissions = Permissions::all();
        $permissionsIds = array_pluck($permissions, 'id');
        $user_id = Auth::user()->id;
        $permissions = [];
        foreach($permissionsIds as $menuVal) 
        {
            $permissions[] = ['permission_id' => $menuVal, 'user_id' => $request->adminstaffid,'physician_id' => $user_id,'created_by'=>$user_id,'updated_by'=>$user_id,'created_at'=>date("Y-m-d H:i:s"),'updated_at'=>date("Y-m-d H:i:s")];
        }
        $adminstaffrepo->get()->permissions()->sync($permissions);
        
        //User::where("id",$request->adminstaffid)->update(['parent_id'=>$user_id]);
        return json_encode(array('success' => true, 'redirectUrl' => route('physician.adminstaff.edit', $request->adminstaffid)));
    }


     /**
     * Ajax content for Listing in popup
     *
     * @return Response
     */
    public function getPopupList(Request $request)
    {

        $userids = PermissionUser::where(['physician_id' => Auth::user()->id])->pluck('user_id')->toArray();
        // $userids = PermissionUser::where(['permission_id' => 8, 'physician_id' => Auth::user()->id])->pluck('user_id')->toArray();

        // echo '<pre>';print_r($userids);exit;
        // $adminstaff = User::select('*')->whereNotIn('id',$userids)->where('practice_id',Auth::user()->practice_id)->where('is_admin_staff','Y')->where('user_role', 'S')->where('parent_id',0)->where('is_account_active', 'Y');
        $adminstaff = User::select('*')->whereNotIn('id',$userids)->where('practice_id',Auth::user()->practice_id)->where('is_admin_staff','Y')->where('user_role', 'S')->where('is_account_active', 'Y');
        return Datatables::of($adminstaff)
                ->addColumn('id', function($adminstaff) {
                    return "<input  type='radio' value='" . $adminstaff->id . "' class='check_boxes check-list-box'>";
                })
                ->addColumn('name', function($adminstaff) {
                    return "<a href='#' class='not-done'>" . $adminstaff->name. " </a>";
                })
                ->addColumn('dob', function($adminstaff) {
                    return (!empty($adminstaff->dob)) ? date('m/d/Y', strtotime($adminstaff->dob)) : "-";
                })
                ->addColumn('contact_no', function($adminstaff) {
                    return $adminstaff->contact_number;
                })
                ->filter(function ($instance) use ($request) {
                    if ($request->has('search') || $request->has('dobSearch')) {
                        $instance->where(function ($query) use ($request) {
                            $searchString1 = trim($request->get('search'));
                            $searchString2 = trim($request->get('dobSearch'));
                            if ($searchString1 != "") {
                                $query->orWhere('name', 'like', "%{$searchString1}%")
                                ->orWhere('email', 'like', "%{$searchString1}%");
                            }
                            if ($searchString2 != "") {
                                $query->orWhere('dob', '=', Carbon::createFromFormat('m/d/Y', $searchString2)->format('Y-m-d'));
                            }
                        });
                    }
                })
                ->make(true);
    }

    /**
     * Redirect to Dashboard
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        if (Auth::user()->user_role == 'S') {
            return view("Physician::adminStaff.dashboard");
        } else {
            return response()->view('errors.404',[],404);
        }
    }
}