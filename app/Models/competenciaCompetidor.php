<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompetenciaCompetidor extends Model {
    use HasFactory;

    protected $table = 'competencia_competidor';
    protected $fillable = [
        'id_competidor',
        'id_competencia',
        'id_poomsae',
        'calificacion',
        'tiempo_presentacion',
        'aprobado',

        // Agrega aquí los nombres de los campos adicionales
    ];

}