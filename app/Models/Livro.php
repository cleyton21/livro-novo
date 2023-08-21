<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Livro extends Model
{
    use HasFactory;

    protected $table = 'livros'; // Nome da tabela se não seguir o padrão de nome do Laravel

    protected $fillable = [
        'dt_ini',
        'dt_end',
        'texto',
        'usuario_id',
    ];

    public function users()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
