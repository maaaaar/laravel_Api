<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\HotelResource;

class CiudadRecource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //nos devuelve toda la ciudad (podemos hacer que nos devuelva lo que queramos)
        return parent::toArray($request);

        //para mostrar los hoteles de cada ciudad
        // return
        // [
        //     "id_ciudad" => $this->id_ciudad,
        //     "nom" => $this->nombre,
        //     //devuelve la lista de hoteles de cada ciudad
        //     "hoteles" => HotelResource::collection($this->hoteles) //hoteles es el nombre de la relacion
        // ];
    }
}