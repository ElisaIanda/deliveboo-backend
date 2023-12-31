<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    use HasFactory;

    

    protected $fillable = [
        'title',
        'description',
        'price',
        'visible',
        'image',
        'discount',
        'ingredients',
        'restaurant_id',
        'category_id',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function orders() {
        return $this->belongsToMany(Order::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }
}
