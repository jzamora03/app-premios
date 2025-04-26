<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prize;


class PrizeController extends Controller
{
    public function index()
    {
        $premios = Prize::orderBy('fecha_creacion', 'desc')->get();
        return view('prizes', compact('premios'));
    }
    
    public function store(Request $request)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'descripcion' => 'nullable|string',
        'fecha_creacion' => 'required|date'
    ]);

    Prize::create($request->all());

    return redirect()->route('prizes.index')->with('success', 'Premio agregado correctamente!');
}
}
