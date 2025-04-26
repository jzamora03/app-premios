@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="text-center"><i class="bi bi-gift"></i> Gestión de Premios</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="text-center mt-3">
        <a href="{{ route('home') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left-circle"></i> Volver al Inicio
        </a>
    </div>

    <form action="{{ route('prizes.store') }}" method="POST" class="border p-4 shadow rounded">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nombre del Premio:</label>
            <input type="text" class="form-control" name="nombre" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción:</label>
            <textarea class="form-control" name="descripcion"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Fecha de Creación:</label>
            <input type="date" class="form-control" name="fecha_creacion" required>
        </div>

        <button type="submit" class="btn btn-success w-100">Agregar Premio</button>
    </form>
</div>
@endsection

@section('scripts')
<script>
document.getElementById("prizeForm").addEventListener("submit", function(event) {
    event.preventDefault();

    let formData = new FormData(this);
    let jsonData = Object.fromEntries(formData.entries());

    fetch("{{ route('prizes.store') }}", {
        method: "POST",
        body: JSON.stringify(jsonData),
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Premio agregado exitosamente! Redirigiendo...");
            window.location.href = "{{ route('home') }}"; 
        } else {
            alert(`Error: ${data.message}`);
        }
    })
    .catch(error => {
        console.error("Error en la solicitud:", error);
        alert(`⚠ Hubo un problema. Verifica los datos e intenta de nuevo.`);
    });
});

</script>
@endsection