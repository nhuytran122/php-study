<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RoomController extends Controller implements HasMiddleware
{
    public static function middleware(): array{
        return [
            new Middleware('role:admin|manager|employee'),
            new Middleware('permission:view-room', only: ['index', 'show']),
            new Middleware('permission:create-room', only: ['create', 'store']),
            new Middleware('permission:edit-room', only: ['edit', 'update']),
            new Middleware('permission:delete-room', only: ['destroy']),
        ];
    }
    
    public function index()
    {
        return response()->json([
            Room::all()
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
        $newRoom = Room::create([
            'name' => $request->name,
            'description' => $request->description
        ]);
        return response()->json([
            'message' => 'Room added successfully',
            'room' => $newRoom
        ], 200);
    }

    public function show(string $id)
    {
        $room = Room::find($id);
        if (!$room) {
            return response()->json([
                'message' => 'Room not found!'
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
        $room = Room::find($id);
        if (!$room) {
            return response()->json([
                'message' => 'Room not found!'
            ], 404);
        }
        $room->update([
            'name' => $request->input('name')
        ]);
        return response()->json([
            'message' => 'Room updated successfully',
            'room' => $room
        ], 200);

    }
    public function destroy(string $id)
    {
        $room = Room::find($id);
        if (!$room) {
            return response()->json([
                'message' => 'Room not found!'
            ], 404);
        }
        $room->delete();
        return response()->json([
            'message' => 'Room deleted successfully'
        ], 200);
    }
}