<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUser;

class UserController extends Controller
{
    private $request;
    /**
     * Create a new controller instance.
     *
     * @param Request $request
     * @return void
     */
    public function __construct(Request $request){
        $this->middleware('auth');
        $this->middleware("role:superadmin,admin");
        $this->request = $request;
    }

    /**
     * Get User Parent Name.
     *
     * @param  $userParentID int User Parent ID
     * @return string
     */
    public static function parentName($userParentID){
        $user = User::findOrFail($userParentID);
        return $user->name;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $sessionData = $this->request->session()->all();
        if($sessionData['userRole'] == 1){
            $userList = DB::table('users AS u')
                            ->join('role_user AS ur', 'u.id', '=', 'ur.id')
                            ->select('u.id','u.name','u.email','ur.role_id','ur.userPlan','ur.parentID','ur.userType')
                            ->where('u.id', '!=', $sessionData['userID'])
                            ->where('ur.role_id', '=', 2)
                            ->orderBy('ur.user_id', 'ASC')
                            ->paginate(10);
        }else{
            $userList = DB::table('users AS u')
                            ->join('role_user AS ur', 'u.id', '=', 'ur.id')
                            ->select('u.id','u.name','u.email','ur.role_id','ur.userPlan','ur.parentID','ur.userType')
                            ->where('ur.parentID', '=', $sessionData['userID'])
                            ->orderBy('ur.user_id', 'ASC')
                            ->paginate(10);
        }
        $userRole = $sessionData['userRole'];
        return view('users.index', compact('userList', 'userRole'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $sessionData = $this->request->session()->all();
        if($sessionData['userRole'] == 1){
            $userType = NULL;
            $userPlan = ['' => '--Select Plan--',
                        '1' => 'Plan 1',
                        '2' => 'Plan 2',
                        '3' => 'Plan 3'];
        }else{
            $userType = ['' => '--Select User Type--',
                        '1' => 'Customer',
                        '2' => 'Vendor',
                        '3' => 'Bilateral',
                        '4' => 'Employee'];
            $userPlan = NULL;
        }
        return view('users.create', compact('userType', 'userPlan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUser $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUser $request){
        $sessionData = $this->request->session()->all();
        if($sessionData['userRole'] == 1){
            $role_admin = Role::where("name", "admin")->first();
            $admin = new User();
            $admin->name = $request['name'];
            $admin->email = $request['email'];
            $admin->password = Hash::make($request['password']);
            $admin->save();
            $admin->roles()->attach($role_admin, ['userPlan' => $request['userPlan']]);

        }else{
            $role_user = Role::where("name", "user")->first();
            $user = new User();
            $user->name = $request['name'];
            $user->email = $request['email'];
            $user->password = Hash::make($request['password']);
            $user->save();
            $user->roles()->attach($role_user, ['userType' => $request['userType'], 'parentID' => $sessionData['userID']]);
        }

        return redirect('users')->with('status', 'Successfully New User Created!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $userID int User ID
     * @return \Illuminate\Http\Response
     */
    public function edit($userID){
        $sessionData = $this->request->session()->all();
        if($sessionData['userRole'] == 1){
            $userType = NULL;
            $userPlan = ['' => '--Select Plan--',
                        '1' => 'Plan 1',
                        '2' => 'Plan 2',
                        '3' => 'Plan 3'];
        }else{
            $userType = ['' => '--Select User Type--',
                        '1' => 'Customer',
                        '2' => 'Vendor',
                        '3' => 'Bilateral',
                        '4' => 'Employee'];
            $userPlan = NULL;
        }
        $user = DB::table('users AS u')
                    ->join('role_user AS ur', 'u.id', '=', 'ur.id')
                    ->select('u.id','u.name','u.email','ur.role_id','ur.userPlan','ur.parentID','ur.userType')
                    ->where('u.id', '=', $userID)
                    ->first();
        return view('users.edit', compact('user', 'userType', 'userPlan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StoreUser  $request
     * @param  $userID int User ID
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUser $request, $userID){
        $updateUser = [
            'name'  => $request['name'],
            'email' => $request['email']
        ];
        DB::table('users')
            ->where('id', '=', $userID)
            ->update($updateUser);

        $sessionData = $this->request->session()->all();
        if($sessionData['userRole'] == 1){
            $updateRole = [
                'userPlan'  => $request['userPlan']
            ];
        }else{
            $updateRole = [
                'userType' => $request['userType'],
                'parentID' => $sessionData['userID']
            ];
        }
        DB::table('role_user')
            ->where('user_id', '=', $userID)
            ->update($updateRole);

        return redirect('users')->with('status', 'Successfully User Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $userID int User ID
     * @return \Illuminate\Http\Response
     */
    public function destroy($userID){
        $user = User::findOrFail($userID);
        $user->forceDelete();
        return redirect('users')->with('status', 'Successfully User Deleted!');
    }
}
