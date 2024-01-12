<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;







class UserController extends Controller
{
    public function index(Request $request)
    {
        // $users = \App\Models\User::paginate(10);
        $users =DB::table('users')
        ->when($request->input('name'), function ($query, $name) {
           return  $query->where('name', 'like', '%' . $name . '%');
        })
        ->orderBy('id','desc')


        ->paginate(10);
        return view('pages.users.list-users',compact('users'));
    }
    public function create()
    {
        return view('pages.users.create');
    }
    public function store(StoreUserRequest $request)
    {
        // $request->validate([
        //     'name' => 'required |max:100|min:3',
        //     'email' => 'required|unique:users,email',
        //     'phone' => 'required |numeric',
        //     'password' => 'required',
        //     'roles' => 'required|in:ADMIN,USER',

        // ]);
      

        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        \App\Models\User::create($data);
        return redirect()->route('user.index')->with('success', 'User created successfully');
    }
    public function edit($id)
    {
        $user = \App\Models\User::findOrFail($id);
        return view('pages.users.edit-user',compact('user'));

    }
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();
        $user = \App\Models\User::findOrFail($id);
        $data['password'] = Hash::make($request->password);
        $user->update($data);
        return redirect()->route('user.index')->with('success', 'User updated successfully');
    }
    public function destroy($id)
    {
        $user = \App\Models\User::findOrFail($id);
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User deleted successfully');
    }

}
