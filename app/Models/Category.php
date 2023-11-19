<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table='category';//đúng tên bảng trong cơ sở dữ liệu
    protected $fillable = ['name','slug'];
    public function products(){
        return $this->hasMany(Product::class,'category_id','id');
    }
}
