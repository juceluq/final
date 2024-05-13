<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Establishment extends Model
{
    use HasFactory;
    protected $table = 'establishments';
    protected $fillable = ['name', 'description', 'location', 'category', 'price', 'image', 'user_id'];
    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
