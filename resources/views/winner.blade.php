@extends('layouts.app')

@section('content')
<div class="container text-center mt-5">
    @if(isset($ganador))
    <div class="card shadow-lg border-0 rounded-3 bg-light p-5 mx-auto" style="max-width: 600px;">
        <h2 class="fw-bold text-success"><i class="bi bi-award-fill"></i> ¡Felicidades, {{ $ganador->nombre }} {{ $ganador->apellido }}!</h2>
        <hr class="my-3">
        <p class="fs-5"><i class="bi bi-trophy-fill text-warning"></i> Has sido seleccionado como el <span class="fw-bold text-primary">GANADOR</span>.</p>
        <p class="fs-5"><i class="bi bi-geo-alt-fill text-danger"></i> Ciudad: <span class="fw-bold">{{ $ganador->ciudad }}</span></p>
        <p class="fs-5"><i class="bi bi-gift-fill text-warning"></i> Premio: <span class="fw-bold">{{ $ganador->prize->nombre ?? 'No asignado' }}</span></p>

        <div class="d-flex justify-content-center mt-4">
            <button class="btn btn-primary btn-lg shadow rounded-pill px-5" onclick="window.location.href='/'">
                <i class="bi bi-house-door-fill"></i> Volver al inicio
            </button>
        </div>
    </div>
    @endif
</div>
@endsection