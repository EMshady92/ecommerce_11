<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    //clave primaria para el modelo para que no incrmenete automaticmante id
    protected $primaryKey = 'iso';

    public $incrementing  = false;

    protected $fillable = [
        'iso',
    ];
}
