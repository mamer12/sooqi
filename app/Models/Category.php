<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Allow mass assignment for these fields
    protected $fillable = [
        'name',
        'slug',
    ];

    // Automatically generate slug if it's not provided
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($category) {
            if (empty($category->slug)) {
                $category->slug = \Illuminate\Support\Str::slug($category->name);
            }
        });
    }
}
