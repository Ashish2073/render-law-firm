<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use DataTables;
use Carbon\Carbon;

class RolePermissionController extends Controller
{
    public function rolePermissionList(Request $request)
    {

        if ($request->ajax()) {

            $rolePermission = Role::query()->with('permissions')->orderBy('id', 'desc')->get();




            return datatables()->of($rolePermission)
                ->addIndexColumn()

                ->addColumn('permissions', function ($row) {

                    $permissions = $row->permissions;

                    $permissionHtml = '<ul>';
                    foreach ($permissions as $data) {

                        $permissionHtml = $permissionHtml . '<li>' . $data->name . '</li>';

                    }
                    $permissionHtml = $permissionHtml . '</ul>';

                    return $permissionHtml;

                })
                ->addColumn('action', function ($row) {
                    $btn = '<button type="button" id="editrolepermission' . $row->id . '" onclick="editRolePermission(' . $row->id . ')" class="edit btn btn-primary mr-2" style="margin-right: 5px;"><i class="far fa-edit"></i></button>';
                    $btn .= '<button type="button" onclick="deleteRolePermission(' . $row->id . ')" class="delete btn btn-danger "><i class="fas fa-trash-alt"></i></button>';
                    return $btn;
                })

                ->addColumn('created_at', function ($row) {


                    $date = Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at);


                    $formattedDate = $date->format('d/m/y');


                    return $formattedDate;
                })

                ->rawColumns(['name', 'permissions', 'action', 'created_at'])
                ->make(true);




        } else {

            return view('user.roleandpermission.index');
        }

    }

    public function rolePermissionSave(Request $request)
    {


        if (isset($request->id)) {


            $validator = Validator::make($request->all(), [
                'permissions' => 'required',
                'role_name' => 'required|unique:roles,name,' . $request->id,
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors(),
                ], 422);
            }



            $role = Role::find($request->id);
            $role->name = $request->input('role_name');
            $role->save();
            $role->syncPermissions($request->input('permissions'));



        } else {

            $validator = Validator::make($request->all(), [
                'permissions' => 'required',
                'role_name' => 'required|unique:roles,name',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation errors',
                    'errors' => $validator->errors(),
                ], 422);
            }



            if ($request->input('role_name') != 'lawyer') {
                $roleName = $request->input('role_name');
                $permissions = $request->input('permissions');
                $role = Role::firstOrCreate(['name' => $roleName]);
                foreach ($permissions as $permissionName) {

                    $permission = Permission::firstOrCreate(['name' => $permissionName]);


                    if (!$role->hasPermissionTo($permissionName)) {
                        $role->givePermissionTo($permissionName);
                    }
                }

            } else {

                $roleName = $request->input('role_name');
                $permissions = $request->input('permissions');
                $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'lawyer']);
                foreach ($permissions as $permissionName) {

                    $permission = Permission::firstOrCreate(['name' => $permissionName, 'guard_name' => 'lawyer']);


                    if (!$role->hasPermissionTo($permissionName)) {
                        $role->givePermissionTo($permissionName);
                    }
                }

            }
        }


        return response()->json(['message' => 'Role and permissions have been assigned successfully.'], 200);
    }


    public function rolePermissionDelete(Request $request)
    {
        $role = Role::find($request->id);

        $role->permissions()->detach();


        $role->delete();

        return response()->json(['message' => 'Role and corresponding permissions deleted successfully'], 200);
    }


    public function rolePermissionEdit(Request $request)
    {


        $rolePermission = Role::with('permissions:id,name')->where('id', $request->id)->get();

        return response()->json([
            'rolePermission' => $rolePermission

        ]);

    }





    // public function rolePermissionUpdate(Request $request, $id)
    // {
    //     $validator=Validator::make($request->all(),[
    //         'name' => 'required',
    //         'permission' => 'required',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Validation errors',
    //             'errors' => $validator->errors(),
    //         ], 422);
    //     }


    //     $role = Role::find($id);
    //     $role->name = $request->input('name');
    //     $role->save();

    //     $role->syncPermissions($request->input('permission'));

    //     return response()->json(['message' => 'Role and permissions updated successfully assigned successfully.'], 200);

    // }
}
