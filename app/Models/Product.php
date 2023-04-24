<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;
      protected $fillable = [
        'title',
        'slug',
        'description',
        'brand_id',
        'category_id',
    ];



    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }



    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

   public  function variant(): HasMany
   {
        return $this->hasMany(Variant::class);
   }

   public function image(): HasMany
   {
       return $this->hasMany(ProductImage::class);
   }
   public function oldestImage(): HasOne
   {
       return $this->hasOne(ProductImage::class)->oldestOfMany();
   }


}
