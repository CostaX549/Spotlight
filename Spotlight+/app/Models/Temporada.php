<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Temporada extends Model
{
    use HasFactory;

    protected $fillable = ['season_number', 'name', 'serie_id'];

    public function serie()
    {
        return $this->belongsTo(Serie::class);
    }
}