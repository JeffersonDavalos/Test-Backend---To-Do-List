<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class tareas extends Model
{
    use HasFactory;

    protected $table = 'tbm_tareas';
    protected $primaryKey = 'id_tareas';
    public $timestamps = false;

    protected $fillable = [
        'titulo',
        'descripcion',
        'materia',
        'orden',
        'fecha_incio',
        'fecha_fin',
        'estado',
        'ip',
        'fecha_creacion',
        'fecha_actualizacion'
    ];
}
