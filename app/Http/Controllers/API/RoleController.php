<?php

namespace App\Http\Controllers\API;

use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Role::orderBy('id', 'desc')->get();
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
            'name' => 'required|unique:roles',
            'description' => 'required'
        ]);
        $role = new Role();
        $role->name = $request->name;
        $role->description = $request->description;
        $role->save();

        return response()->json([
            'message' => 'role has been created',
            'role' => $role
        ]);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        $this->validate($request, [
            'name' => 'required|unique:roles,name,' . $role->id,
            'description' => 'required'
        ]);
        $role->name = $request->name;
        $role->description = $request->description;
        $role->save();
        return response()->json([
            'message' => 'role has been updated',
            'role' => $role
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $role = Role::find($id);
        
        $role->delete();
        return response()->json([
            'message' => "role has been deleted",
        ], 200);
    }
    public function search(Request $request)
    {
        if ($request->input('query')) {
            $roles = Role::search($request->input('query'))->get();
        } else {
            $roles =  Role::orderBy('id', 'desc')->get();
        }

        return response()->json([
            'roles' => $roles
        ]);
    }
}
