<?php

namespace App\Http\Controllers;

use App\Models\Tarjeta;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TarjetaUsuarioController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:tarjetas.index')->only('index');
        $this->middleware('can:tarjetas.edit')->only('edit', 'update');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tarjetas = Tarjeta::all();
        return view('tarjetas.index', compact('tarjetas')); // Corregido el retorno de la vista y pasando las tarjetas
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$tarjetas=Tarjeta::all();
        return view("tarjetas.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
        "nombre" => "required",
        "ap" => "required",
        "am" => "required",
        "numero" => "required|string|between:16,25",
        "fecha" => "required|string|size:5",
        "cvc" => "required|string|size:3",
    ]);

    // Obtén el usuario autenticado
    $user = auth()->user();

    // Crear nueva instancia de Reservacion
    $tarjeta = new Tarjeta;

    // Asignar valores de la reservación
    $tarjeta->nombre = $request->nombre;
    $tarjeta->ap = $request->ap;
    $tarjeta->am = $request->am;
    $tarjeta->numero = $request->numero;
    $tarjeta->fecha = $request->fecha;
    $tarjeta->cvc = $request->cvc;
    $tarjeta->user_id = $user->id; // Asignar el ID del usuario autenticado

    // Guardar la reservación
    $tarjeta->save();

    /*Tarjeta::create([
        "nombre" => $request->nombre,
        "ap" => $request->ap,
        "am" => $request->am,
        "numero" => $request->numero,
        "fecha" => $request->fecha,
        "cvc" => $request->cvc,
    ]);*/

    if (auth()->user()->hasRole('Admin')) 
    {
        return redirect()->route('tarjetas.index');
    } 
    else 
    {
        return redirect()->route('tickets.create');
    }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tarjeta  $tarjeta
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tarjeta = Tarjeta::find($id);
        return view('tarjetas.show', compact('tarjeta'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tarjeta  $tarjeta
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $tarjeta = Tarjeta::findOrFail($id);
        return view('tarjetas.edit', compact('tarjeta'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tarjeta  $tarjeta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tarjeta = Tarjeta::findOrFail($id);

        

        $tarjeta->update([
            "nombre" => $request->nombre,
            "ap" => $request->ap,
            "am" => $request->am,
            "numero" => $request->numero,
            "fecha" => $request->fecha,
            "cvc" => $request->cvc,
        ]);

        return redirect()->route("tarjetas.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tarjeta  $tarjeta
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tarjeta = Tarjeta::find($id);

        $tarjeta->delete();
        $tarjeta->forceDelete();
        return redirect()->route("tarjetas.index");
    }
}
