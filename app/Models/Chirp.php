<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Chirp extends Model
{
    protected $table = 'livros';

    use HasFactory;

    // protected $table = 'chirp'; // Nome da tabela se não seguir o padrão de nome do Laravel

    protected $fillable = [
        'dt_ini',
        'dt_end',
        'texto',
        'usuario_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
