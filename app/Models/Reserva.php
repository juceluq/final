<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;
    protected $table = 'reservas';
    protected $fillable = ['user_id', 'establishment_id', 'price', 'start_date', 'end_date', 'phone', 'status'];
    public function getFormattedStartDateAttribute()
    {
        return Carbon::parse($this->start_date)->format('d-m-Y');
    }
    public function getFormattedEndDateAttribute()
    {
        return Carbon::parse($this->end_date)->format('d-m-Y');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
