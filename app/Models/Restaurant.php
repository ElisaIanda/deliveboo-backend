<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'owner_name',
        'address',
        'slug',
        'vat',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function type() {
        return $this->belongsToMany(Type::class);
    }
}
