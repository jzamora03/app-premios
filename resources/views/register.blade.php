@extends('layouts.app')

@section('content')
<div class="container mt-5 animate__animated animate__fadeIn">
    <h2 class="text-center">Registro en el Concurso</h2>

    <form id="registrationForm" action="{{ route('participants.store') }}" method="POST" class="border p-4 shadow rounded bg-light">
        @csrf
    
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold"><i class="bi bi-person"></i> Nombre:</label>
                <input type="text" class="form-control effect-focus" name="nombre" required>
            </div>
    
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold"><i class="bi bi-card-text"></i> Apellido:</label>
                <input type="text" class="form-control effect-focus" name="apellido" required>
            </div>
    
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold"><i class="bi bi-credit-card-2-front"></i> Cédula:</label>
                <input type="number" class="form-control effect-focus" name="cedula" required>
            </div>
    
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold"><i class="bi bi-geo-alt"></i> Departamento:</label>
                <select class="form-select effect-focus" id="departamento" name="departamento" required>
                    <option value="" disabled selected>Seleccione un departamento</option>
                    <option value="Bogotá">Bogotá</option>
                    <option value="Antioquia">Antioquia</option>
                    <option value="Valle del Cauca">Valle del Cauca</option>
                </select>
            </div>
    
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold"><i class="bi bi-building"></i> Ciudad:</label>
                <select class="form-select effect-focus" id="ciudad" name="ciudad" required>
                    <option value="" disabled selected>Seleccione una ciudad</option>
                </select>
            </div>
    
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold"><i class="bi bi-phone"></i> Celular:</label>
                <input type="tel" class="form-control effect-focus" name="celular" required>
            </div>
    
            <div class="col-md-12 mb-3">
                <label class="form-label fw-bold"><i class="bi bi-envelope"></i> Correo Electrónico:</label>
                <input type="email" class="form-control effect-focus" name="correo_electronico" required>
            </div>
    
            <div class="mb-3 text-center">
                <div class="form-check d-flex justify-content-center align-items-center">
                    <input type="checkbox" class="form-check-input me-2" name="habeas_data">
                    <label class="form-check-label">Autorizo el tratamiento de mis datos</label>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <button type="submit" id="submitBtn" class="btn btn-primary btn-lg w-100">
                        <i class="bi bi-send"></i> Registrarse
                    </button>
                </div>
                <div class="col-md-6">
                    <a href="{{ route('home') }}" class="btn btn-secondary btn-lg w-100">
                        ⬅️ Volver al Inicio
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let departamentoSelect = document.getElementById("departamento");
        let ciudadSelect = document.getElementById("ciudad");
        let form = document.getElementById("registrationForm");

        const ciudades = {
            "Bogotá": ["Bogotá"],
            "Antioquia": ["Medellín", "Envigado", "Itagüí"],
            "Valle del Cauca": ["Cali", "Palmira", "Buga"]
        };

        departamentoSelect.addEventListener("change", function() {
            let departamentoSeleccionado = this.value;
            ciudadSelect.innerHTML = "";

            if (ciudades[departamentoSeleccionado]) {
                ciudades[departamentoSeleccionado].forEach(ciudad => {
                    let opcion = document.createElement("option");
                    opcion.value = ciudad;
                    opcion.textContent = ciudad;
                    ciudadSelect.appendChild(opcion);
                });

                ciudadSelect.classList.add("animate__animated", "animate__fadeIn");
            }
        });

        form.addEventListener("submit", function(event) {
    event.preventDefault(); 

    let formData = new FormData(this);
    
    formData.set("habeas_data", formData.get("habeas_data") ? 1 : 0);

    let jsonData = Object.fromEntries(formData.entries()); 

    fetch("{{ route('participants.store') }}", {
        method: "POST",
        body: JSON.stringify(jsonData),
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log("Respuesta del servidor:", data);
        if (data.success) {
            alert("Registro exitoso! Redirigiendo...");
            form.reset();
            setTimeout(() => {
                window.location.href = "{{ route('home') }}";
            }, 2000);
        } else {
            alert(`Error: ${data.message}`);
        }
    })
    .catch(error => {
        console.error("Error en la solicitud:", error);
        alert(`⚠ Hubo un problema. Verifica los datos e intenta de nuevo.`);
    });
});
});
</script>

@endsection