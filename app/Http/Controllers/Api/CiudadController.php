<?php

namespace App\Http\Controllers\Api;

use App\Models\Ciudad;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CiudadRecource;
use Illuminate\Database\QueryException;
use App\Clases\Utilitats;

class CiudadController extends Controller
{
    //devuelve las ciudades de la BD
    public function index()
    {
        //guardamos las ciudades a una variable
        $ciudades = Ciudad::all();
        //devuelve un json con todas las ciudades
        return CiudadRecource::collection($ciudades);
        //return new CiudadesResource($ciudades);
    }

    //para crear una ciudad
    public function store(Request $request)
    {
        $ciudad = new Ciudad();
        $ciudad->id_ciudad = $request->input('id_ciudad');
        $ciudad->nombre = $request->input('nombre');

        try
        {
            $ciudad->save();
            //el status es para dar el mensaje en el postman status
            $respuesta = (new CiudadRecource($ciudad))->response()->setStatusCode(201);
        }
        catch (QueryException $e)
        {
            $mensaje = Utilitats::errorMessage($e);
            $respuesta = response()->json(['error'=>$mensaje], 400);
        }

        return $respuesta;
    }

    //nos devuelve una sola ciudad
    public function show($id_ciudad)
    {
        //find busca por clave primaria
        //el with es para que se muestre los hoteles en cada ciudad
        $ciudad = Ciudad::with('hoteles')->find($id_ciudad);

        return new CiudadRecource($ciudad);
    }

    public function update(Request $request, Ciudad $ciudad)
    {
        //
    }

    // para borrar ciudad
    public function destroy($id_ciudad)
    {
        $ciudad = Ciudad::find($is_ciudad);

        //para comprobar si la ciudad exsiste o no
        if ($ciudad == null)
        {
            $respuesta = response()->json(['error' => 'registro no encontrado'], 404);
        }
        else
        {
            try
            {
                $ciudad->delete();
                $respuesta = (new CiudadRecource($ciudad))->response()->setStatusCode(200);
            }
            catch (QueryException $e)
            {
                $mensaje = Utilitats::errorMessage($e);
                $respuesta = response()->json(['error'=>$mensaje], 400);
            }
        }

        return $respuesta;
    }
}