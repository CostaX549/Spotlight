<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteSerie extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'serie_id'];
    protected $table = 'favorite_series'; // ou o nome que você escolheu para a tabela de favoritos

    public function user()
    {
        return $this->belongsTo(User::class);
    }

   
    
    
}
