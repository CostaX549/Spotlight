<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteMovie extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'movie_id'];

    protected $table = 'favorite_movies'; // ou o nome que você escolheu para a tabela de favoritos

    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->select('id');
    }

    
}
