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
        $user = auth()->user();

        $studios = $user->ownedStudios;
        return response()->json(['message' => 'Your Studios', 'data' => $studios]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StudioRequest $request)
    {
        $data = $request->validated();

        $existingStudio = Studio::
        where('name', $data['name'])
            ->exists();
        if ($existingStudio) {
            return response()->json(['message' => 'Studio name  already exists']);
        }

        $studio = new Studio();
        $studio->name = $data['name'];
        $studio->user_id = auth()->user()->id;
        $studio->save();


        $studio->members()->attach(auth()->user());

        return response()->json(['message' => 'Studio created successfully', 'data' => new StudioResource($studio)], 201);

    }
}
