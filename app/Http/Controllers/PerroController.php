<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        return view('perros.create', compact('perro'));
        
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
        Perro::find($id);
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
        Perro::find($id);
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
        Perro::find($id)->update($request->all());
        return redirect()->route('perros.index')
            ->with('success', 'Perro actualizado correctamente.');
        
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
        return redirect()->route('perros.index')
            ->with('success', 'Perro eliminado correctamente.');
    }
}
