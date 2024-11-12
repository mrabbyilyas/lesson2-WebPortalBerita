<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Author extends Model
{
    use hasfactory, SoftDeletes;

    protected $fillable = [
        'name', 
        'slug',
        'occupation', 
        'avatar', 
    ];

    public function news(): HasMany
    {
        return $this->hasMany(ArticleNews::class);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }
}
