<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['filename', 'establishment_id'];

    public function establishment() {
        return $this->belongsTo(Establishment::class);
    }
    
}
