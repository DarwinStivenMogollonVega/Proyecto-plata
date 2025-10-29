<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\CategoriaRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class CategoriaController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('categoria-list'); 
        $texto=$request->input('texto');
        $registros=Categoria::where('nombre', 'like',"%{$texto}%")
                    ->orWhere('codigo', 'like',"%{$texto}%")
                    ->orderBy('id', 'desc')
                    ->paginate(10);
        return view('categoria.index', compact('registros','texto'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('categoria-create'); 
        return view('categoria.action');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoriaRequest $request)
    {
        $this->authorize('categoria-create'); 
        $registro = new Categoria();
        $registro->codigo=$request->input('name');
        $registro->nombre=$request->input('description');
        $registro->save();
        return redirect()->route('categoria.index')->with('mensaje', 'Registro '.$registro->nombre. '  agregado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $this->authorize('user-edit'); 
        $categorias=Categoria::all();
        $registro=Categoria::findOrFail($id);
        return view('usuario.action', compact('registro','categorias'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(CategoriaRequest $request)
    {
        $this->authorize('categoria-create'); 
        $registro=new Categoria();
        $registro->name=$request->input('name');
        $registro->email=$request->input('description');
        $registro->save();

        return redirect()->route('categoria.index')->with('mensaje', 'Registro '.$registro->name. '  agregado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->authorize('categoria-delete');
        $registro=Categoria::findOrFail($id);
        $registro->delete();

        return redirect()->route('categroia.index')->with('mensaje', $registro->name. ' eliminado correctamente.');
    }
}
