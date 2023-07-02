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
        // Procesar la carga de archivos
        $imagePath = "default.png";
        $array = $request->all();
        $perro = json_decode($array["perro"], true);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            // Guardar la imagen en la carpeta 'perros' dentro de la carpeta 'public'
            $imagePath = $image->store('perros', 'public'); 
        }

        // Crear un nuevo perro con los datos recibidos
        $nuevoPerro = new Perro();
        $nuevoPerro->race = $perro["race"];
        $nuevoPerro->name = $perro["name"];
        $nuevoPerro->size = $perro["size"];
        $nuevoPerro->hair_color = $perro["hair_color"];
        // Guardar la ruta de la imagen en la propiedad 'image'
        $nuevoPerro->img_url = $imagePath; 

        // Guardar el nuevo perro en la base de datos
        $nuevoPerro->save();

        // Redireccionar o enviar una respuesta al cliente
        return response()->json([
            'message' => 'Perro creado correctamente',
            'perro' => $nuevoPerro,
        ]);
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

        $imagePath = "perros/default.jpg";
        $array = $request->all();
        $perroUpdated = json_decode($array["perro"], true);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            // Guardar la imagen en la carpeta 'perros' dentro de la carpeta 'public'
            $imagePath = $image->store('perros', 'public'); 
        }

        // Obtener el perro a actualizar
        $perro = Perro::find($id);

        // Actualizar los datos del perro con los valores del formulario
        $perro->race = $perroUpdated["race"];
        $perro->name = $perroUpdated["name"];
        $perro->size = $perroUpdated["size"];
        $perro->hair_color = $perroUpdated["hair_color"];
        $perro->img_url = $imagePath; 
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
