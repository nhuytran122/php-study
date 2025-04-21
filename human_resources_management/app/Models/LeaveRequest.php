<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    public function employee(){
        return $this->belongsTo(Employee::class);
    }

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];
}