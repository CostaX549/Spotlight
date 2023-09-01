<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'overview', 'vote_average', 'backdrop_path','id'];

    public function temporadas()
    {
        return $this->hasMany(Temporada::class);
    }


   
}
