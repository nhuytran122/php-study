<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
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
        return $this->hasMany(Employee::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'date_of_birth' => 'date',
        'is_active' => 'boolean',
        'hire_date' => 'date',
    ];
    

}