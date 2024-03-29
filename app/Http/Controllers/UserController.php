<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct()
     {
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:user-create', ['only'=>['create', 'store']]);
        $this->middleware('permission:user-edit', ['only'=>['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
     }

    public function index(Request $request)
    {
        $data = User::orderBy('id', 'DESC')->paginate(10);
        return view('users.index', compact('data'))->
    with('i', ($request->input('page', 1)- 1) *5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::get(['id', 'name'])->all();
        //dd($roles);
        return view('users.create', compact('roles'));
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
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'email|unique:users,email|required',
            'password' => 'required|same:confirm-password',
            'roles' => 'required',
        ]);

        if($request->hasFile('signature')){
            $fileNameExtension = $request->file('signature')->getClientOriginalName();
            $fileExtension = $request->file('signature')->getClientOriginalExtension();
            $fileName = pathinfo($fileNameExtension, PATHINFO_FILENAME);
            $nameToStore = $fileName.'_'.time().'.'.$fileExtension;
          //  $path = $request->file('signature')->storeAs('/public/uploads/signatures', $nameToStore);
          $path = $request->file('signature')->move(public_path('uploads/signature'), $nameToStore);
        }
        $user = User::create([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'email' => $request->email,
            'dept' => $request->dept,
            'designation' => $request->designation,
            'signature' => $nameToStore,
            'password' =>Hash::make($request->password),
        ]);

        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')->with('message', 'User created successfully');
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
        return view('users.show', compact('user'));
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
        $roles = Role::get(['id', 'name']);
     //dd($roles);
        $userRole = $user->roles->pluck('id')->toArray();
        return view('users.edit', compact('user', 'roles', 'userRole'));
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
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'email|required',
            'roles' => 'required',

        ]);

        $input = $request->all();

        if (!empty($request->input('password'))) {
            $input['password'] = Hash::make($input['password']);
        }else {
            $input = Arr::except($input, array('password'));
        }
if(!empty($request->signature)){
    if ($request->hasFile('signature')) {
        $fileNameExtension = $request->file('signature')->hashName();
        $fileExtension = $request->file('signature')->getClientOriginalExtension();
        $fileName = pathinfo($fileNameExtension, PATHINFO_FILENAME);
        $nameToStore = $fileName.'_'.time().'.'.$fileExtension;
        $path = $request->file('signature')->move(public_path('uploads/signatures'), $nameToStore);
    }
    $input['signature'] = $nameToStore;

}else {
    $input = Arr::except($input, array('signature'));
}
        
        $user = User::findOrFail($id);

        $input = Arr::except($input, array('roles'));
        $user->update($input);
        $user->syncRoles($request->input('roles'));
        return redirect()->route('users.index')->with('message', 'User has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id)->delete();
        return redirect()->route('users.index')->with('message', 'User has been deleted successfully');

    }
}
