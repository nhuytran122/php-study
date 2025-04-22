<?php

namespace App\Http\Controllers;

use App\Models\LeaveType;
use Illuminate\Http\Request;

class LeaveTypeController extends Controller {
    
    public function index()
    {
        return response()->json([
            LeaveType::all()
        ]);
    }
    
    public function create()
    {
        
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'max_days' => 'nullable|numeric',
            'is_paid' => 'required|boolean'
        ]);
        $newLeaveType = LeaveType::create([
            'name' => $request->name,
            'description' => $request->description ?? '',
            'max_days' => $request->max_days,
            'is_paid' => $request->is_paid,
        ]);
        return response()->json([
            'message' => 'Leave Type added successfully',
            'leave_type' => $newLeaveType
        ], 200);
    }

    public function show(string $id)
    {
        $leave_type = LeaveType::find($id);
        if (!$leave_type) {
            return response()->json([
                'message' => 'Leave Type not found!'
            ], 404);
        }
    }

    public function edit(string $id)
    {
        
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'max_days' => 'nullable|numeric',
            'is_paid' => 'required|boolean'
        ]);
        $leave_type = LeaveType::find($id);
        if (!$leave_type) {
            return response()->json([
                'message' => 'Leave Type not found!'
            ], 404);
        }
        $leave_type->update([
            'name' => $request->name,
            'description' => $request->description ?? '',
            'max_days' => $request->max_days,
            'is_paid' => $request->is_paid,
        ]);
        return response()->json([
            'message' => 'Leave Type updated successfully',
            'leave_type' => $leave_type
        ], 200);

    }
    public function destroy(string $id)
    {
        $leave_type = LeaveType::find($id);
        if (!$leave_type) {
            return response()->json([
                'message' => 'Leave Type not found!'
            ], 404);
        }

        $hasRequest = $leave_type->leave_requests()->exists();

        if ($hasRequest) {
            return response()->json([
                'message' => 'Cannot delete leave type because this leave type has request records.'
            ], 400);
        }
        $leave_type->delete();
        return response()->json([
            'message' => 'Leave Type deleted successfully'
        ], 200);
    }
}