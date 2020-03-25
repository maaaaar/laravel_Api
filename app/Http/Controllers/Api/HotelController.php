<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function index()
    {
        $hoteles = Hotel::all();
        return HotelResource::collection($hoteles);
    }

    public function store(Request $request)
    {
        $hotel = new Hotel();
        $hotel-> //id_ciudad
        $hotel->nombre = $request->input('nombre');
        $hotel->categoria = $request->input('categoria');
        $hotel->direccion = $request->input('direccion');
        $hotel->cif = $request->input('cif');

        try
        {
            $hotel->save();
            $respuesta = (new HotelResource($hotel))->response()->setStatusCode(201);
        }
        catch (QueryException $e)
        {
            $mensaje = Utilitats::errorMessage($e);
            $respuesta = response()->json(['error'=>$mensaje], 400);
        }

        return $respuesta;
    }

    public function show(Hotel $hotel)
    {
        $hotel = Hotel::with('cadena')->find($nombre);
        return new HotelResource($hotel);
    }

    public function update(Request $request, Hotel $hotel)
    {
        $hotel->nombre = $request->input('nombre');

        try
        {
            $hotel->save();
            $respuesta = (new HotelResource($hotel))->response()->setStatusCode(201);
        }
        catch (QueryException $e)
        {
            $mensaje = Utilitats::errorMessage($e);
            $respuesta = response()->json(['error'=>$mensaje], 400);
        }

        return $respuesta;
    }

    public function destroy(Hotel $hotel)
    {
        $hotel = Hotel::find();

        //para comprobar si la ciudad exsiste o no
        if ($hotel == null)
        {
            $respuesta = response()->json(['error' => 'registro no encontrado'], 404);
        }
        else
        {
            try
            {
                $hotel->delete();
                $respuesta = (new HotelResource($hotel))->response()->setStatusCode(200);
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
