<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudioRequest;
use App\Http\Resources\StudioResource;
use App\Models\Studio;
use App\Models\User;
use Illuminate\Http\Request;

class StudioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $studios = Studio::all();
        return response()->json(['message' => 'All Studio Members', 'data' => $studios]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StudioRequest $request)
    {
        $studio = new Studio();
        $studio->name = $request->input('name');
        $studio->user_id = auth()->user()->id;
        $studio->save();
        auth()->user()->ownedStudios()->attach($studio);

        return response()->json(['message' => 'Studio created successfully', 'data' => new StudioResource($studio)], 201);

    }


    /**
     * Display the specified resource.
     */
    public function show(Studio $studio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Studio $studio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Studio $studio)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Studio $studio)
    {
        //
    }
}
