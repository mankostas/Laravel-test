<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'category', 'price', 'tags', 'release_date']; 

    protected $casts = [
        'tags' => 'array'
    ];

}
