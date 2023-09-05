<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class UserController extends Controller
{

    function __construct()
    {
        //  $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','show']]);
         $this->middleware('permission:user-list', ['only' => ['index']]);
         $this->middleware('permission:user-create', ['only' => ['create','store']]);
         $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $data = User::orderBy('id','DESC')->where('type','!=','admin')->where('id','!=',auth()->user()->id)->get();
        return view('admin.user.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.create');
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
            'first_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',

        ]);

        $input = $request->except(['_token', 'profile','password_confirm'],$request->all());

        $input['password'] = Hash::make($input['password']);
        if($request->hasFile('profile'))
        {
            $img = Str::random(20).$request->file('profile')->getClientOriginalName();
            $input['profile'] = $img;
            $request->profile->move(public_path("documents/profile"), $img);
        }
        $user = User::create($input);

        return redirect()->back()->with(['message'=>'User created successfully','type'=>'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('admin.user.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $user = User::find($id);
         return view('admin.user.edit',compact('user'));
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

        $this->validate($request, [
            // 'first_name' => 'required',
            //'email' => 'required|email|unique:users,email,',
            // 'password' => 'same:confirm-password',
            // 'role_id' => 'required'
        ]);

        $input = $request->all();

        if($request->hasFile('profile'))
        {
            $img = Str::random(20).$request->file('profile')->getClientOriginalName();
            $input['profile'] = $img;
            $request->profile->move(public_path("documents/profile"), $img);
        }
         $user = User::find($id);
        $user->update($input);
        return redirect()->back()
                ->with(['message'=>'User update successfully','type'=>'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        User::find($id)->delete();
        return redirect()->route('users.index')
                        ->with(['message'=>'User delete successfully','type'=>'success']);
    }
     public function change_status(Request $request)
    {
        $statusChange = User::where('id',$request->id)->update(['status'=>$request->status]);
        if($statusChange)
        {
            return array('message'=>'User status  has been changed successfully','type'=>'success');
        }else{
            return array('message'=>'User status has not changed please try again','type'=>'error');
        }

    }
}
