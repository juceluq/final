<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Establishment extends Model
{
    use HasFactory;
    protected $table = 'establishments';
    protected $fillable = ['name', 'description', 'location', 'category', 'image', 'user_id'];

    function split_description($text, $length = 60)
    {
        $parts = str_split($text, $length);
        return $parts;
    }
}
