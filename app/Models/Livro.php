<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Livro extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_livro';

    protected $fillable = [
        'nome_livro', 'id_livro_google', 'id_usuario', 'img_livro', 'lido', 'total_paginas', 'tempo_lido', 'paginas_lidas', 'descricao_livro', 'data_inicio',
        'data_termino', 'show_in_pacoca', 'uuid'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id');
    }
}
