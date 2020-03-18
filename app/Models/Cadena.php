<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cadena extends Model
{
    protected $table = 'cadenas';
    protected $primaryKey = 'cif';
    public $incrementing = false; //porque el dni no es incremental
    protected $keyType = 'string';

    public $timestamps = false;

    // N/M una pelicula puede tener muchos temas
    public function hoteles()//tambla donde vamos
    {
        return $this->hasMany('App\Models\Hotel','cif'); // (tabla relacionada,la tabla que se a creado a partir de las dos ,id de una tabla,id de la otra(los campos que hay en la tabla creada en la BD))
    }
}