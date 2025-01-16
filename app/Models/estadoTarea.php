<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class estadoTarea extends Model
{
    use HasFactory;

    protected $table = 'tbm_estado_tareas';

    public $timestamps = false;

    protected $fillable = [
        'descripcion',
        'estado',
        'ip',
        'fecha_creacion'
    ];
}
