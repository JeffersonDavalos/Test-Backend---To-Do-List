<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class materias extends Model
{
    use HasFactory;

    protected $table = 'tbm_materia';

    public $timestamps = false;

    protected $fillable = [
        'descripcion',
        'nombre',
        'estado',
        'ip',
        'fecha_creacion'
    ];}
