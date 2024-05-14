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

    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'reservas');
    }
}
