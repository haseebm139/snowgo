<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Traits\PermissionTrait;
use Illuminate\Support\Str;

use App\Models\User;
use DB;


class RoleController extends Controller
{

    function __construct()
    {
        //  $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
        //  $this->middleware('permission:role-create', ['only' => ['create','store']]);
        //  $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
        //  $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::orderBy('id','ASC')->get();
         return view('admin.roles.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permission_type = Permission::groupBy('type')->pluck('type');
        $permission =  Permission::get();
        return view('admin.roles.create',compact('permission','permission_type'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);

         $request->all();
    //    return   ucwords(Str::slug($request->name, ' '));
    //     return Str::slug($request->name, '-');
        $role = Role::create(['name' => $request->input('name'),'display_name'=>ucwords(Str::slug($request->name, ' ')),'slug'=> Str::slug($request->name, '-')]);
        $role->syncPermissions($request->input('permission'));

        return redirect()->route('roles.index')
                ->with(['message'=>'Role created successfully','type'=>'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);

       $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
        $permission = Permission::get();
        $type  = [];
        foreach($permission as $key => $item)
        {
           $type[$item->type]  = $item->type;
        }

        return view('admin.roles.edit',compact('role','permission','rolePermissions','type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $permission = [];
         $permission = $request->input('permission');

        $role_id =  Role::where('name',$request->name)->first()->id;
        $this->validate($request, [
            'name' => 'required',
            // 'permission' => 'required',
        ]);

        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();
        if($permission != null)
        {
            $role->syncPermissions($request->input('permission'));
            // $role->assignRole('admin');
        }else{
           $role = DB::table('role_has_permissions')->where('role_id', $role_id)->delete();
        }

        return redirect()->back()
                ->with(['message'=>'Role Update successfully','type'=>'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function give_role(Request $request)
    {
        // return $request->role;

        $user = User::find($request->id);
        $role = Role::find($request->role);
        DB::table('model_has_roles')->where(['model_id'=>$request->id])->delete();
        // $user->removeRole($request->role);
        $user->assignRole($role->name);
        return array('message'=>'Success');
    }
}
