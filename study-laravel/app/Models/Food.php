<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;
    // Tên tables, tên cột có thể khác biệt
    protected $table = 'foods';
    protected $primaryKey = 'id';

    //Nếu k muốn dùng createdAt/updateAt: set false
    public $timestamps = true;
    // protected $dateFormat = 'h:m:s';

    protected $fillable = ['name', 'description', 'count', 'category_id'];
    
    public function category(){
        return $this->belongsTo(Category::class);
    }
}