<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        // 'image',
        'slug',
        'is_active',
    ];
    public function category()
    {
        return $this->hasMany(App\Models\Product::class);
    }
}
