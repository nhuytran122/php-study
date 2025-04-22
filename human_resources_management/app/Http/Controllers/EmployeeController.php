<?php

namespace App\Http\Controllers;

use App\Helpers\DateHelper;
use App\Models\Employee;
use App\Models\LeaveBalance;
use App\Models\LeaveType;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller {
    
    public function index()
    {
        return response()->json([
            Employee::all()
        ]);
    }
    
    public function create()
    {
        
    }

    public function store(Request $request)
    {
        $this->mergeDateFields($request);
        $this->validateEmployee($request); 
        
        return DB::transaction(function () use ($request) {
            $avatarPath = null;
            $cvPath = null;
            $contractPath = null;

            if ($request->hasFile('avatar')) {
                $avatarPath = $this->uploadFile($request->file('avatar'), 'images', $request->full_name);
            }

            if ($request->hasFile('cv')) {
                $cvPath = $this->uploadFile($request->file('cv'), 'cvs', $request->full_name);
            }

            if ($request->hasFile('contract')) {
                $contractPath = $this->uploadFile($request->file('contract'), 'contracts', $request->full_name);
            }

            $user = User::create([
                'name'     => $request->full_name,
                'email'    => $request->email,
                'password' => Hash::make(config('custom.default_password')),
            ]);

            $newEmployee = Employee::create([
                'full_name'     => $request->full_name,
                'gender'        => $request->gender,
                'date_of_birth' => $request->date_of_birth,
                'phone'         => $request->phone,
                'address'       => $request->address,
                'hire_date'     => $request->hire_date,
                'avatar'        => $avatarPath,
                'cv'            => $cvPath,
                'contract'      => $contractPath,
                'position_id'   => $request->position_id,
                'department_id' => $request->department_id,
                'user_id'       => $user->id,
            ]);

            $currentYear = now()->year;
            $leaveTypes = LeaveType::whereNotNull('max_days')->get();

            foreach ($leaveTypes as $type) {
                if ($type->applicable_gender !== 'all' && $type->applicable_gender !== $request->gender) {
                    continue;
                }
                LeaveBalance::create([
                    'employee_id'    => $newEmployee->id,
                    'leave_type_id'  => $type->id,
                    'remaining_days' => $type->max_days,
                    'year'           => $currentYear,
                ]);
            }

            return response()->json([
                'message'  => 'Employee added successfully',
                'employee' => $newEmployee
            ], 201);
        });
    }
    
    public function show(string $id)
    {
        $employee = Employee::find($id);
        if (!$employee) {
            return response()->json([
                'message' => 'Employee not found!'
            ], 404);
        }
    }

    public function edit(string $id)
    {
        
    }

    public function update(Request $request, string $id)
    {
        $this->mergeDateFields($request);
        $this->validateEmployee($request, true);  

        $employee = Employee::find($id);
        if (!$employee) {
            return response()->json([
                'message' => 'Employee not found!'
            ], 404);
        }

        $employeeData = [
            'full_name'     => $request->full_name,
            'gender'        => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'phone'         => $request->phone,
            'address'       => $request->address,
            'hire_date'     => $request->hire_date,
            'position_id'   => $request->position_id,
            'department_id' => $request->department_id,
        ];

        $employee->update($employeeData);
        if ($request->hasFile('avatar')) {
            $avatarPath = $this->uploadFile($request->file('avatar'), 'images', $request->full_name);
            $employee->update(['avatar' => $avatarPath]);
        }
        if ($request->hasFile('cv')) {
            $cvPath = $this->uploadFile($request->file('cv'), 'cvs', $request->full_name);
            $employee->update(['cv' => $cvPath]);
        }
        if ($request->hasFile('contract')) {
            $contractPath = $this->uploadFile($request->file('contract'), 'contracts', $request->full_name);
            $employee->update(['contract' => $contractPath]);
        }

        return response()->json([
            'message' => 'Employee updated successfully',
            'employee' => $employee
        ], 200);
    }

    
    public function destroy(string $id)
    {
        $employee = Employee::find($id);
        if (!$employee) {
            return response()->json([
                'message' => 'Employee not found!'
            ], 404);
        }
        $hasSalary = $employee->salaries()->exists();

        if ($hasSalary) {
            return response()->json([
                'message' => 'Cannot delete employee because this employee has salary records.'
            ], 400);
        }
        $employee->delete();
        return response()->json([
            'message' => 'Employee deleted successfully'
        ], 200);
    }

    private function validateEmployee(Request $request, $isUpdate = false)
    {
        $rules = [
            'email'         => 'required|string|email',
            'full_name'     => 'required|string|max:255',
            'gender'        => 'required|string|in:female,male,other',
            'date_of_birth' => 'required|date',
            'phone' => [
                'required',
                'regex:/(?:\+84|0084|0)[235789][0-9]{1,2}[0-9]{7}(?:[^\d]+|$)/'
            ],
            'address'       => 'required|string|max:255',
            'hire_date'     => 'required|date',
            'avatar'        => 'file|image|mimes:jpeg,png,jpg|max:5048',
            'cv'            => 'file|mimes:pdf,doc,docx|max:5048',
            'contract'      => 'file|mimes:pdf,doc,docx|max:5048',
            'position_id'   => 'exists:positions,id',
            'department_id' => 'exists:departments,id',
        ];

        if ($isUpdate) {
            // Bỏ validation cho email vì email không thay đổi
            unset($rules['email']);
        }

        $request->validate($rules);
    }


    private function mergeDateFields(Request $request)
    {
        $request->merge([
            'hire_date' => DateHelper::toDateFormat($request->hire_date),
            'date_of_birth' => DateHelper::toDateFormat($request->date_of_birth),
        ]);
    }

    private function uploadFile($file, $folder, $name)
    {
        $fileName = time() . '-' . str_replace(' ', '_', $name) . '.' . $file->extension();
        $file->move(public_path($folder), $fileName);
        return $folder . '/' . $fileName;
    }
}