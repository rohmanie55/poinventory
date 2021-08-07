<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.index', ['users'=> User::get() ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|max:100|unique:users',
            'email' => 'required|max:200|unique:users',
            'name' => 'required|max:255',
            'password' => 'required',
            'role' => 'required',
        ]);
        //hasing
        $request['password'] = bcrypt($request->password);

        User::create($request->except('token'));

        return redirect()->route('user.index')->with('message', 'Success creating user!');
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
        return view('user.edit', ['user' => User::findOrFail($id)]);
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
        $request->validate([
            'username' => 'required|max:100|unique:users,username,'.$id,
            'email' => 'required|max:200|unique:users,email,'.$id,
            'name' => 'required|max:255',
            'role' => 'required',
        ]);
        //hasing
        if($request->password)
            $request['password'] = bcrypt($request->password);
        else
            unset($request['password']);

        User::find($id)->update($request->all());

        return redirect()->route('user.index')->with('success', 'Successfull update user!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            User::findOrFail($id)->delete();

            return redirect()->route('user.index')->with('success', 'Successfull deleting user!');
       } catch (\Throwable $th) {
            return redirect()->route('user.index')->with('fail', 'Failed deleting user!');
       }
    }
}
