<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

use App\Models\Cadena;
use App\Models\Ciudad;

class Hotel extends Model
{
    protected $table = 'hoteles';
    protected $primaryKey = ['id_ciudad', 'nombre'];
    public $incrementing = false; //porque el dni no es incremental
    protected $keyType = 'int';

    public $timestamps = false;

    // N/M una pelicula puede tener muchos temas
    public function ciudad()//tambla donde vamos
    {
        return $this->belongsTo('App\Models\Ciudad','id_ciudad'); // (tabla relacionada,la tabla que se a creado a partir de las dos ,id de una tabla,id de la otra(los campos que hay en la tabla creada en la BD))
    }

    public function cadena()
    {
        return $this->belongsTo('App\Models\Cadena', 'cif');
    }

    //cuando haga un save le indica cuales son las claves primary
    public function setKeysForSaveQuery(Builder $query)
    {
        $query
            ->where('id_ciudad', '=', $this->getAttribute('id_ciudad'))
            ->where('nombre', '=', $this->getAttribute('nombre'));
        return $query;
    }
}
