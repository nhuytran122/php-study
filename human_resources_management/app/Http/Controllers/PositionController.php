<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PositionController extends Controller {
    
    public function index()
    {
        return response()->json([
            Position::all()
        ]);
    }
    
    public function create()
    {
        
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required'
        ]);
        $newPosition = Position::create([
            'name' => $request->name,
            'description' => $request->description
        ]);
        return response()->json([
            'message' => 'Position added successfully',
            'position' => $newPosition
        ], 200);
    }

    public function show(string $id)
    {
        $position = Position::find($id);
        if (!$position) {
            return response()->json([
                'message' => 'Position not found!'
            ], 404);
        }
    }

    public function edit(string $id)
    {
        
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);
        $position = Position::find($id);
        if (!$position) {
            return response()->json([
                'message' => 'Position not found!'
            ], 404);
        }
        $position->update([
            'name' => $request->input('name')
        ]);
        return response()->json([
            'message' => 'Position updated successfully',
            'position' => $position
        ], 200);

    }
    public function destroy(string $id)
    {
        $position = Position::find($id);
        if (!$position) {
            return response()->json([
                'message' => 'Position not found!'
            ], 404);
        }
        $position->delete();
        return response()->json([
            'message' => 'Position deleted successfully'
        ], 200);
    }
}