<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salaries extends Model
{
    public function employee(){
        return $this->belongsTo(Employee::class);
    }

    protected $casts = [
        'is_paid' => 'boolean',
        'is_locked' => 'boolean',
    ];
}