<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use DataTables;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;


class UserController extends Controller
{
    public function userList(Request $request)
    {

        if ($request->ajax()) {

              $user = User::query()
                ->select('users.*', \DB::raw("DATE_FORMAT(users.created_at ,'%d/%m/%Y') AS created_date"))
                ->orderBy('users.created_at', 'desc');

            return datatables()->of($user)
                ->addIndexColumn()

                ->addColumn('role', function ($row) {
                    // return $row->getRoleNames();  <button class='btn btn-danger role-view btn-icon btn-round'  onclick='userRole($row->id)' ><i class='feather icon-eye'></i></button>";
    
                    $usersrole = json_decode($row->getRoleNames(), true);
                    if (count($usersrole) == 0) {
                        $rolesHtml = "<label for='positiveNumber' id='userrole'><div  class='role-card-1 btn btn-danger'>
                    <h5>No Role</h5>
                    </div>";

                        return $rolesHtml;


                    }

                    $rolesHtml = "<label for='positiveNumber' id='userrole'>";

                    foreach ($usersrole as $role) {


                        $rolesHtml = $rolesHtml . "
                    <div class='role-card-1'>
                    <h5>$role</h5>
                    </div>";

                    }

                    $rolesHtml = $rolesHtml . '</label>';

                    return $rolesHtml;

                })


                ->addColumn('action', function ($row) {
                    $btn = '<button type="button" id="editUser' . $row->id . '" onclick="editUser(' . $row->id . ')" class="edit btn btn-primary mr-2" style="margin-right: 5px;"><i class="far fa-edit"></i></button>';
                    $btn .= '<button type="button" onclick="workInProgress(' . $row->id . ')" class="delete btn btn-danger "><i class="fas fa-trash-alt"></i></button>';
                    return $btn;
                })

                ->addColumn('status', function ($row) {

                    $status_text = $row->status == 1 ? 'Active' : 'Inactive';

                    $status_btn = $row->status == 1 ? 'btn btn-success' : 'btn btn-danger';

                    $user_status = "<button type='button' id='statuschange$row->id' onclick='changeStatus($row->id)' 
                class='$status_btn'>$status_text</button>";





                    return $user_status;



                })



                ->rawColumns(['name', 'role', 'action', 'status'])
                ->make(true);




        } else {

            $roles = Role::all();

            return view('user.userlist.index', ['roles' => $roles]);

        }



    }


    public function userSave(Request $request)
    {



        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'sucess' => false,
                'errormessage' => $validator->errors(),


            ], 422);


        }

        $user = new User();

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        if ($user && isset($request->roles)) {
            $role_ids = explode(',', $request->roles);
            $user->roles()->sync($role_ids);
        }


        return response()->json([
            'status' => true,
            'message' => 'User Resistration Happen successfully'
        ]);


    }



    public function userStatusUpdate(Request $request)
    {


        $user = User::find($request->userId);
        $user->status = $request->status;

        $user->save();

        return response()->json([
            'id' => $user->id,
            'status' => $user->status,

        ], 200);

    }


    public function userEdit(Request $request)
    {

        $user = User::findOrFail($request->id);

        $roles = Role::all();

        $editFormHtml = View::make('user.userlist.edit', ['user' => $user, 'roles' => $roles])->render();

        return response()->json([
            'editHtml' => $editFormHtml
        ]);


    }



    public function userUpdate(Request $request)
    {



        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|max:255|unique:users,email,' . $request->id,

        ]);

        if (!empty($request->password)) {

            $validator = Validator::make($request->all(), [
                'password' => 'required|confirmed|min:6',

            ]);

        }

        if ($validator->fails()) {
            return response()->json([
                'success' => false,

                'errormessage' => $validator->errors(),


            ], 422);


        }

        $user = User::find($request->id);

        $user->name = $request->name;

        $user->email = $request->email;

        $user->save();

        if ($user) {

            $userRoleData = $user->roles->pluck('id')->toArray();

            $userRoleDataLength = count($userRoleData);

            $reqRoleData = explode(',', $request->roles);

            $reqRoleDataLength = count($reqRoleData);

            $userRoleChange = false;

            


            foreach ($reqRoleData as $role) {

               
                if (in_array($role, $userRoleData) && ($userRoleDataLength == $reqRoleDataLength)) {
                    $userRoleChange = false;
                } else {
                    $userRoleChange = true;
                    
                }
            }


            if ($userRoleChange) {
                if(empty($reqRoleData[0])){
                    $user->roles()->detach();
                    $roleNames=0;
                }else{
                $user->roles()->sync($reqRoleData);
                $updatedRoles = $user->roles()->get();       
                $roleNames = $updatedRoles->pluck('name');
                }
               
            }else{
                $roleNames=false;
            }



        }


    

       



        return response()->json([
            'status' => true,
            'user' => $user,
            'roles' => $roleNames,
            'message' => 'User Updated  successfully'
        ]);



    }








}
