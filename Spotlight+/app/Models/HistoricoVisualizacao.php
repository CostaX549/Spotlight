<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoVisualizacao extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'media_id',    // ID da mídia (filme ou série)
        'media_type',  // Tipo de mídia (filme ou série)
        'created_at',
        'updated_at',
    ];

    protected $table = 'historico_visualizacoes'; // Nome da tabela

  

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->select('id');
    }



    
}
