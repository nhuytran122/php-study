<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        
        $attendances = Attendance::where('month', $request->month ?? now()->month())
                ->where('year', $request->year ?? now()->year())
                ->get();
        return response()->json([
            'data' => $attendances
        ], 200);
    }

    public function create(Request $request)
    {
        try {
            return DB::transaction(function () use ($request) {
                $month = $request->month ?? now()->month();
                $year = $request->year ?? now()->year();
                $beginOfMonth = Carbon::createFromDate($year, $month, 1)->startOfDay();
                $endOfMonth = Carbon::createFromDate($year, $month, 1)->endOfMonth()->endOfDay();

                $now = Carbon::now();
                if ($now->lt($endOfMonth)) {
                    return response()->json([
                        'message' => 'Chỉ tổng kết ngày công sau khi hết tháng'
                    ], 400);
                }
                
                $workingDaysInMonth = $this->calculateWorkingDaysInMonth($beginOfMonth, $endOfMonth);  
                $leaveRequests = LeaveRequest::with('leave_type')
                ->where(function ($query) use ($beginOfMonth, $endOfMonth) {
                    $query->whereBetween('start_date', [$beginOfMonth, $endOfMonth])
                        ->orWhereBetween('end_date', [$beginOfMonth, $endOfMonth]);
                })
                ->where('status', 'approved')
                ->get();

                $leaveData = [];
                foreach ($leaveRequests as $leaveRequest) {
                    $leaveData[$leaveRequest->employee_id][] = $leaveRequest;
                }

                Employee::chunk(100, function ($employees) use ($month, $year, $workingDaysInMonth, $leaveData) {
                    foreach ($employees as $employee) {
                        $this->calculateWorkingDaysForEmployee($employee->id, $month, $year, $workingDaysInMonth, $leaveData);
                    }
                });
                $attendances = Attendance::where('month', $month)
                                        ->where('year', $year)
                                        ->get();

                return response()->json([
                    'message' => 'Tổng kết ngày công thành công',
                    'data' => $attendances
                ], 201);
            });
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    protected function calculateWorkingDaysInMonth($beginOfMonth, $endOfMonth)
    {
        $workingDaysInMonth = 0;
        foreach ($beginOfMonth->copy()->daysUntil($endOfMonth) as $date) {
            if ($date->isWeekday()) {
                $workingDaysInMonth++;
            }
        }
        return $workingDaysInMonth;
    }

    protected function calculateWorkingDaysForEmployee($employeeId, $month, $year, $workingDaysInMonth, $leaveData)
    {
        $existingAttendance = Attendance::where('employee_id', $employeeId)
            ->where('month', $month)
            ->where('year', $year)
            ->first();  
            
        if ($existingAttendance) {
            return; 
        }
        $leaveRequests = isset($leaveData[$employeeId]) ? $leaveData[$employeeId] : [];

        $leaveDaysTaken = 0;
        $paidLeaveDays = 0;

        for ($i = 0; $i < count($leaveRequests); $i++) {
            $leaveRequest = $leaveRequests[$i];
            $days = $leaveRequest->start_date->diffInDays($leaveRequest->end_date) + 1;

            if ($leaveRequest->leave_type && !$leaveRequest->leave_type->is_paid) {
                $leaveDaysTaken += $days; 
            } else {
                $paidLeaveDays += $days; 
            }
        }

        Attendance::create([
            'employee_id' => $employeeId,
            'month' => $month,
            'year' => $year,
            'working_days' => $workingDaysInMonth - $leaveDaysTaken, 
            'leave_days' => $leaveDaysTaken, 
            'paid_leave_days' => $paidLeaveDays, 
        ]);
    }
}