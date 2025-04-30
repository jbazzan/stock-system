<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():JsonResource
    {
        return RoleResource::collection(Role::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        $role=Role::create($request->validated());
        return response()->json([
            'message'=>'Role created successfully',
            'role'=>$role
        ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id):JsonResource
    {
        $role=Role::find($id);
        return new RoleResource($role);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRoleRequest $request, string $id)
    {
        $role=Role::find($id);
        $role->update($request->validated());
        return response()->json([
            'message'=>'Role updated successfully', 
            'role'=> $role
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role=Role::find($id);
        $role->delete();
        return response()->json([
            'message'=>'Role deleted successfully'
        ], 200);
    }
}
