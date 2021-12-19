<?php namespace App\Modules\Physician\Repositories;

use App\User;
use App\Modules\Physician\Models\PermissionUser;
// use DB;
use App\Session;

class AdminStaffRepository extends BaseRepository
{

    protected $model;
    /**
     * The Role instance.
     *
     * @var \App\Models\Role
     */
    public function __construct()
    {
        $this->model = new User();
    }

    /**
     * Get all Admin Staffs.
     *
     * @return \Illuminate\Support\Collection
     */
    public function all($userId,$request)
    {       
        // $query = $this->model->where('practice_id',\Auth::user()->practice_id)->where('user_role', 'S');
        
        // // $query = DB::table('users')
        // //     ->join('permission_user', 'users.id', '=', 'permission_user.user_id')
        // //     ->where('permission_user.physician_id', $userId)
        // //     ->where('user_role', 'S')
        // //     ->groupBy('permission_user.user_id')
        // //     ->get();
        // if(\Auth::user()->user_role == 'S') // exclude this user from listing
        //     $query->where('id','!=', \Auth::user()->id);            
        // return $query;
        $userIds = $userPermisionsIds = [];
        // $query = $this->model->where('practice_id',\Auth::user()->practice_id)->where('parent_id', $userId)->where('user_role', 'S');
        // echo '<pre>';dd($query);
        $query = $this->model->where('practice_id',\Auth::user()->practice_id)->where('users.user_role', 'S')
                        ->leftJoin('permission_user','permission_user.physician_id', 'users.id')
                        ->select('users.*', 'permission_user.physician_id')
                        ->where('permission_user.physician_id',$userId);
        
        if($request->has('search'))
        {
            $searchText = $request->get('search'); 
            $query->where(function ($query1) use ($searchText) {
                $query1->orWhere('name', 'like', "%{$searchText}%")
                ->orWhere('email', 'like', "%{$searchText}%");
            });
        }
        $directUsers = $query->get();
        
        $userIds = $query->pluck('id')->toArray();

        if(\Auth::user()->user_role == 'S') // exclude this user from listing
        {
            $query->where('id','!=', \Auth::user()->id);            
        }
        if(\Auth::user()->user_role == 'D') // exclude this user from listing
        {
            $userPermisionsIds = PermissionUser::where("physician_id",\Auth::user()->id)->whereNotIn("user_id",$userIds)->pluck('user_id')->toArray();
            if(count($userPermisionsIds))
            {
                $query = $this->model->where('practice_id',\Auth::user()->practice_id)->whereIn('id', $userPermisionsIds)->where('user_role', 'S');
                if($request->has('search'))
                {
                    $searchText = $request->get('search'); 
                    $query->where(function ($query1) use ($searchText) {
                        $query1->orWhere('name', 'like', "%{$searchText}%")
                        ->orWhere('email', 'like', "%{$searchText}%");
                    });
                }

                $inDirectUsers = $query->get(); 
                return $directUsers->merge($inDirectUsers);
            }
            else
            {
                return $directUsers;
            }
        }
        else
        {
            return $directUsers;
        }
    }

    /**
     * Save Administrative Staff.
     *
     * @return \Illuminate\Support\Collection
     */
    public function save($inputData)
    {
        $inputData['password']  = bcrypt($inputData['password']);
        $inputData['user_role'] = 'S';
        $result                 = $this->model->create($inputData);
        return $result;
    }
    /**
     * Update Administrative Staff.
     *
     * @return \Illuminate\Support\Collection
     */
    public function update($inputData)
    {
       $result               = $this->model->where('id', $inputData['id'])->update($inputData);
       return $result;
    }
    /**
     * Get Administrative Staff.
     *
     * @return \Illuminate\Support\Collection
     */
    public function get()
    {       
       return $this->model;
    }   
}