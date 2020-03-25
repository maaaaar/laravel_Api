<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ciudad extends Model
{
    protected $table = 'ciudades';
    protected $primaryKey = 'id_ciudad';
    public $incrementing = false; //porque el dni no es incremental
    protected $keyType = 'int';

    public $timestamps = false;

    public function hoteles()//tambla donde vamos
    {
        return $this->hasMany('App\Models\Hotel','id_ciudad'); // (tabla relacionada,la tabla que se a creado a partir de las dos ,id de una tabla,id de la otra(los campos que hay en la tabla creada en la BD))
    }
}
