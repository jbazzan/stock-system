<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():JsonResource
    {
        return ClientResource::collection(Client::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClientRequest $request)
    {
        $client=Client::create($request->validated());
        return response()->json(['message'=>'Client created in successfully.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id):JsonResource
    {
        $client=Client::find($id);
        return new ClientResource($client);
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClientRequest $request, string $id)
    {
        $client=Client::find($id);
        $client->update($request->validated());
        return response()->json(['message'=>'Client updated in successfully.'], 200);
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client=Client::find($id);
        $client->delete();
        return response()->json(null, 204);

    }
}
