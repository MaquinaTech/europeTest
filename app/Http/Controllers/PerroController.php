<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Perro;


class PerroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perros = Perro::all();

        return view('perros.index', compact('perros'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('perros.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Perro::create($request->all());
        return redirect()->route('perros.index')
            ->with('success', 'Perro creado correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $perro = Perro::find($id);
        return view('perros.show', compact('perro'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $perro = Perro::find($id);
        return view('perros.edit', compact('perro'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'race' => 'required',
            'name' => 'required',
        ]);
    
        if ($validator->fails()) {
            // La validación ha fallado
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Obtener el perro a actualizar
        $perro = Perro::find($id);

        // Actualizar los datos del perro con los valores del formulario
        $perro->race = $request->race;
        $perro->name = $request->name;
        $perro->size = $request->size;
        $perro->hair_color = $request->hair_color;
        $perro->save();

        // Devolver una respuesta JSON
        return response()->json([
            'message' => 'Perro actualizado correctamente',
            'perro' => $perro
        ]);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Perro::find($id)->delete();
        $perros = Perro::all();
        return response()->json([
            'message' => 'Perro eliminado correctamente',
        ]);
    }
}
