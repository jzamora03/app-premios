<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participant;
use App\Models\Prize;

class ParticipantController extends Controller
{

    public function index()
{
    $participants = Participant::with('prize')->orderBy('created_at', 'desc')->get(); 
    $totalParticipantes = Participant::count();
    $ultimoParticipante = Participant::orderBy('created_at', 'desc')->first();
    $ganadores = Participant::where('ganador', true)->orderBy('created_at', 'desc')->get();

    $premio = Prize::orderBy('created_at', 'desc')->first();

    return view('index', compact('participants', 'totalParticipantes', 'ultimoParticipante', 'ganadores', 'premio'));
}

 
    public function store(Request $request)
    {
        try {
            $participant = new Participant();
            $participant->fill($request->all());
    
            $participant->created_at = now();
            // $participant->updated_at = now();
            
            $participant->save();
    
            return response()->json(['success' => true, 'message' => 'Registro exitoso'], 201);
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error interno en el servidor',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function seleccionarGanador()
{
    if (Participant::count() >= 5) {
        $ganador = Participant::where('ganador', false)->inRandomOrder()->first();
        $premio = Prize::inRandomOrder()->first();

        if ($ganador && $premio) {
            $ganador->ganador = true;
            $ganador->prize_id = $premio->id;
            $ganador->save();

            return view('winner', compact('ganador'));
        } else {
            return redirect()->back()->with('error', 'No hay premios disponibles o todos los participantes ya han ganado.');
        }
    }

    return redirect()->back()->with('error', 'Debe haber al menos 5 usuarios registrados.');
}


            public function apiParticipants()
        {
            return response()->json(Participant::orderBy('created_at', 'desc')->get());
        }

}