<?php

namespace App\Models;

use App\Models\Department;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Employee extends Model
{
    use LogsActivity;

    protected $fillable = ['full_name', 'gender', 'date_of_birth', 'phone', 'address', 
    'hire_date', 'avatar', 'cv', 'contract', 'is_working', 'user_id', 'department_id', 'position_id'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
        ->logOnly(['*'])
        ->useLogName('employee')     
        ->logOnlyDirty();
    }
    public function department(){
        return $this->belongsTo(Department::class);
    }
    public function position(){
        return $this->belongsTo(Position::class);
    }
    public function leave_requests(){
        return $this->hasMany(LeaveRequest::class);
    }
    public function leave_balances(){
        return $this->hasMany(LeaveBalance::class);
    }
    public function attendances(){
        return $this->hasMany(Attendance::class);
    }
    public function salaries(){
        return $this->hasMany(Salary::class);
    }
    
    public function approved_requests() {
        return $this->hasMany(LeaveRequest::class, 'approved_by');
    }

    public function managesDepartment() {
        return $this->hasOne(Department::class, 'manager_id');
    }    

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'date_of_birth' => 'date',
        'is_working' => 'boolean',
        'hire_date' => 'date',
    ];
    

}