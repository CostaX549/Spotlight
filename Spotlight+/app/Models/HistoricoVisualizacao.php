<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoVisualizacao extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'media_id',    
        'media_type',  
        'created_at',
        'updated_at',
    ];

    protected $table = 'historico_visualizacoes'; 

  

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->select('id');
    }



    
}
