<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudioRequest;
use App\Http\Resources\StudioResource;
use App\Models\Studio;

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
     * Store a newly created resource in storage.
     */
    public function store(StudioRequest $request)
    {
        $date = $request->validated();
        $studio = new Studio();
        $studio->name = $date['name'];
        $studio->user_id = auth()->user()->id;
        $studio->save();
        auth()->user()->ownedStudios()->attach($studio);

        return response()->json(['message' => 'Studio created successfully', 'data' => new StudioResource($studio)], 201);

    }
}
