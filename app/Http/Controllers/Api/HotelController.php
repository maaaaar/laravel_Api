<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function index()
    {
        try
        {
            $hoteles = Hotel::all();
        } catch (QueryException $e) {
            $mensaje = Utilitats::errorMessage($e);
            $respuesta = response()->json(['error'=>$mensaje], 403);
        }

        //devuelve un json con todas las ciudades
        return HotelResource::collection($hoteles);
    }

    public function store(Request $request)
    {
        $hotel = new Hotel();
        $hotel->id_ciudad = $request->input('id_ciudad');
        $hotel->nombre = $request->input('nombre');
        $hotel->categoria = $request->input('categoria');
        $hotel->direccion = $request->input('direccion');
        $hotel->cif = $request->input('cif');

        try
        {
            $hotel->save();
            //$respuesta = (new HotelResource($hotel))->response()->setStatusCode(201);
        }
        catch (QueryException $e)
        {
            $mensaje = Utilitats::errorMessage($e);
            $respuesta = response()->json(['error'=>$mensaje], 400);
        }

        return (new HotelResource ($hotel))
            ->response()
            ->setStatusCode(201);

    }

    public function show($id, $nombre)
    {
        $hotel = Hotel::with('cadena')->find($nombre);
        return new HotelResource($hotel);
        try
        {
            $hotel = Hotel::where('id_ciudad', $id)->where("nombre", $nombre)->first();
            if($hotel == null)
            {
                return response()->json(['error'=> "No s'ha trobat l'hotel"], 404);
            }
        }
        catch (QueryException $e)
        {
            $mensaje = Utilitats::errorMessage($e);
            $respuesta = response()->json(['error'=>$mensaje], 403);
        }

        return HotelResource($hoteles);
    }

    public function update(Request $request, $id,$nombre)
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