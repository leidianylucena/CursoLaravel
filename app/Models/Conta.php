<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conta extends Model
{
    use HasFactory;

    // indicar o nome da tabela
    protected $table = 'contas';

    // indicar quais colunas podem ser cadastradas
    protected $fillable = ['nome', 'valor', 'vencimento'];
}
