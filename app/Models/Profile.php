<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use Uuid;
    use SoftDeletes;

    /**
     * Os atributos que podem ser atribuidos em massa.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'content',
    ];

    /**
     * Transforma o content em array assim que recebe do banco
     * de dados o json "content", faz o inverso quando vamos
     * inserir no banco de dados, ao invés de encodar o
     * array para json e decodar quando recebemos do banco de dados
     * esse cast faz automaticamente.
     * 
     * @var array
     */
    protected $casts = [
        'content' => 'array',
    ];
}
