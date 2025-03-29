<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable =
    [
        'name',
        'main_category_id',
        'image_id',
        'slug',
        'title',
        'description'
    ];
}
