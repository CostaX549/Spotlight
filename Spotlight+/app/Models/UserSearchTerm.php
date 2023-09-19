<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSearchTerm extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'search_term'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->select('id');
    }
}
