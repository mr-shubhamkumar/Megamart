<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    protected $fillable=[
        'image',
        'name',
        'slug',
        'is_active'
    ];

    public function brand()
    {
        return $this->hasMany(App\Models\Product::class);
    }

}
