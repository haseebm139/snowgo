<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class UserPatternController extends Controller
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
         $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->userRepository->getAllUser();
        return view('admin.userpattern.index',compact('data'))->withUser($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.userpattern.create');
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
        $user = $this->userRepository->createUser($input);

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

        $user = $this->userRepository->getUserId($id);
        return view('admin.userpattern.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $user = $this->userRepository->getUserId($id);
         return view('admin.userpattern.edit',compact('user'));
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
            // 'email' => 'required|email|unique:users,email,',
            // 'password' => 'same:confirm-password',
            // 'role_id' => 'required'
        ]);

        $input = $request->except(['_token','_method'],$request->all());
         if($request->hasFile('profile'))
        {
            $img = Str::random(20).$request->file('profile')->getClientOriginalName();
            $input['profile'] = $img;
            $request->profile->move(public_path("documents/profile"), $img);
        }

          $user = $this->userRepository->updateUser($id,$input);
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
        $user = $this->userRepository->deleteUser($id);
        return redirect()->route('userspattern.index')
                        ->with(['message'=>'User delete successfully','type'=>'success']);
    }
}
