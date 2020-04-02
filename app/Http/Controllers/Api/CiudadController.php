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
        try
        {
            //guardamos las ciudades a una variable
            $ciudades = Ciudad::all();
        } catch (QueryException $e) {
            $mensaje = Utilitats::errorMessage($e);
            $respuesta = response()->json(['error'=>$mensaje], 403);
        }

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

        try
        {
            //find busca por clave primaria
            //el with es para que se muestre los hoteles en cada ciudad
            //para coger los hoteles de las ciudades (relacion models)
                    //$ciudad = Ciudad::with('hoteles','hoteles.cadena')->find($id_ciudad); -->para devolver hoteles y cadenas
            $ciudad = Ciudad::with('hoteles')->find($id_ciudad);
            if($ciudad == null)
            {
                return response()->json(['error'=> "No s'ha trobat la ciutat"], 404);
            }
        }
        catch (QueryException $e)
        {
            $mensaje = Utilitats::errorMessage($e);
            $respuesta = response()->json(['error'=>$mensaje], 403);
        }

        return new CiudadRecource($ciudad);
    }

    public function update(Request $request, Ciudad $ciudad)
    {
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

    // para borrar ciudad
    public function destroy($id_ciudad)
    {
        $ciudad = Ciudad::find($id_ciudad);

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
