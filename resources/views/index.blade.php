@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center fw-bold text-primary animate__animated animate__fadeIn">
        <i class="bi bi-stars"></i> Bienvenido al Gran Concurso
    </h1>
    
    @if(session('error'))
        <div class="alert alert-danger"><i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}</div>
    @endif

    <div class="row justify-content-center text-center mb-4">
        <div class="col-md-4 mb-3">
            <div class="card shadow-lg border-0 rounded-3 bg-primary text-white p-4 h-100">
                <h5 class="card-title"><i class="bi bi-people-fill"></i> Total de Participantes</h5>
                <p class="card-text display-4 fw-bold">{{ $totalParticipantes }}</p>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card shadow-lg border-0 rounded-3 bg-info text-white p-4 h-100">
                <h5 class="card-title"><i class="bi bi-person-plus-fill"></i> Último Registrado</h5>
                <p class="card-text fw-bold">{{ $ultimoParticipante->nombre ?? 'Sin datos' }}</p>
                <p class="text-muted">{{ $ultimoParticipante->ciudad ?? 'No registrada' }}</p>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card shadow-lg border-0 rounded-3 bg-success text-white p-4 h-100">
                <h5 class="card-title"><i class="bi bi-gift-fill"></i> Último Premio</h5>
                <p class="card-text fw-bold">{{ $premio->nombre ?? 'Sin premio' }}</p>
                <p class="text-muted">{{ $premio->descripcion ?? 'No disponible' }}</p>
                <p class="text-muted">Fecha: {{ $premio->fecha_creacion->format('d-m-Y') ?? 'No definida' }}</p>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="w-50">
            <input type="text" id="searchBar" class="form-control" placeholder="🔍 Buscar participante..." onkeyup="buscarParticipante()">
        </div>
        <div>
            <a href="{{ route('participants.register') }}" class="btn btn-primary btn-sm shadow rounded-2 px-3">
                <i class="bi bi-plus-circle"></i> Registrar
            </a>
            <a href="{{ route('prizes.index') }}" class="btn btn-warning btn-sm shadow rounded-2 px-3">
                <i class="bi bi-gift"></i> Agregar
            </a>
            <button id="btn-ganador" onclick="elegirGanador()" class="btn btn-success btn-sm shadow rounded-2 px-3">
                <i class="bi bi-trophy-fill"></i> Ganador
            </button>
            <button class="btn btn-info btn-sm shadow rounded-2 px-3" data-bs-toggle="modal" data-bs-target="#modalGanadores">
                <i class="bi bi-award-fill"></i> Historial
            </button>

            <button id="downloadExcel" class="btn btn-success btn-sm shadow rounded-2 px-3">
                <i class="bi bi-file-earmark-excel"></i> Excel
            </button>
            
            
        </div>
    </div>
    
    
    @if(isset($participants) && $participants->isNotEmpty()) 
    <table class="table table-sm table-striped table-hover table-bordered shadow-sm rounded-3">
        <thead class="table-dark text-center">
            <tr>
                <th><i class="bi bi-person"></i> Nombre</th>
                <th><i class="bi bi-card-text"></i> Apellido</th>
                <th><i class="bi bi-geo-alt"></i> Cedula</th>
                <th><i class="bi bi-geo-alt"></i> Departamento</th>
                <th><i class="bi bi-geo-alt"></i> Ciudad</th>
                <th><i class="bi bi-geo-alt"></i> Celular</th>
                <th><i class="bi bi-geo-alt"></i> Correo electronico</th>
            </tr>
        </thead>
        <tbody>
            @foreach($participants as $participant)
            <tr class="text-center {{ $participant->ganador ? 'table-danger' : 'table-success' }}">
                <td class="fw-bold">{{ $participant->nombre }}</td>
                <td>{{ $participant->apellido }}</td>
                <td class="text-muted">{{ $participant->cedula }}</td>
                <td class="text-muted">{{ $participant->departamento }}</td>
                <td class="text-muted">{{ $participant->ciudad }}</td>
                <td class="text-muted">{{ $participant->celular }}</td>
                <td class="text-muted">{{ $participant->correo_electronico }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    @else
        <p class="text-center"><i class="bi bi-exclamation-diamond-fill"></i> Aún no hay participantes registrados.</p>
    @endif

    <div class="modal fade" id="modalGanadores" tabindex="-1" aria-labelledby="modalGanadoresLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content shadow-lg rounded-3">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalGanadoresLabel"><i class="bi bi-award-fill"></i> Historial de Ganadores</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    @if(isset($ganadores) && $ganadores->isNotEmpty()) 
                    <table class="table table-striped table-hover table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th><i class="bi bi-person"></i> Nombre</th>
                                <th><i class="bi bi-card-text"></i> Apellido</th>
                                <th><i class="bi bi-geo-alt"></i> Ciudad</th>
                                <th><i class="bi bi-calendar-check"></i> Fecha de Ganador</th>
                                <th><i class="bi bi-gift-fill"></i> Premio</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ganadores as $ganador)
                            <tr>
                                <td>{{ $ganador->nombre }}</td>
                                <td>{{ $ganador->apellido }}</td>
                                <td>{{ $ganador->ciudad }}</td>
                                <td>{{ $ganador->updated_at->format('d-m-Y') }}</td>
                                <td>{{ $ganador->prize->nombre ?? 'Sin premio' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                        <p class="text-center text-muted"><i class="bi bi-exclamation-triangle-fill"></i> No hay ganadores registrados aún.</p>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
    function cargarParticipantes() {
        fetch("/api/participants")
        .then(response => response.json())
        .then(data => {
            console.log("Participantes recibidos:", data);

            let tablaBody = document.getElementById("tabla-participantes");
            tablaBody.innerHTML = "";

            data.forEach(participant => {
                let row = `<tr>
                    <td>${participant.nombre}</td>
                    <td>${participant.apellido}</td>
                    <td>${participant.ciudad}</td>
                </tr>`;
                tablaBody.innerHTML += row;
            });

            let botonGanador = document.getElementById("btn-ganador");
            botonGanador.style.display = data.length >= 5 ? "block" : "none";
        })
        .catch(error => console.error("Error al obtener participantes:", error));
    }

    cargarParticipantes();
    });

    function elegirGanador() {
    let boton = document.getElementById("btn-ganador");
    boton.innerText = "Eligiendo...";
    boton.disabled = true;
    boton.classList.add("animando");

    let contador = document.createElement("h3");
    contador.classList.add("text-center", "fw-bold", "mt-3", "text-danger");
    contador.innerHTML = `Elegiendo ganador en <span class="text-dark">5</span> segundos...`;
    document.getElementById("btn-ganador").parentNode.appendChild(contador); 

    let tiempo = 5;

    let intervalo = setInterval(() => {
        tiempo--;
        contador.innerHTML = `Elegiendo ganador en <span class="text-dark">${tiempo}</span> segundos...`;

        if (tiempo <= 0) {
            clearInterval(intervalo);
            window.location.href = "{{ route('seleccionarGanador') }}";
        }
    }, 1000);
  }


    function buscarParticipante() {
        let input = document.getElementById("searchBar").value.toLowerCase();
        let rows = document.querySelectorAll("#tabla-participantes tr");

        rows.forEach(row => {
            let nombre = row.children[0].innerText.toLowerCase();
            let apellido = row.children[1].innerText.toLowerCase();
            row.style.display = (nombre.includes(input) || apellido.includes(input)) ? "" : "none";
        });
    }


    document.addEventListener("DOMContentLoaded", function() {
    let botonDescarga = document.getElementById('downloadExcel');

    if (!botonDescarga) {
        console.error("Error: No se encontró el botón de descarga.");
        return;
    }

    botonDescarga.addEventListener('click', function() {
        let table = document.querySelector(".table");

        if (!table) {
            console.error("Error: No se encontró la tabla.");
            return;
        }

        let data = [];
        let rows = table.querySelectorAll("tr");

        rows.forEach((row) => {
            let rowData = [];
            row.querySelectorAll("td, th").forEach((cell) => {
                rowData.push(cell.innerText.trim());
            });
            data.push(rowData);
        });

        let ws = XLSX.utils.aoa_to_sheet(data);
        let wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, "Participantes");
        XLSX.writeFile(wb, "participantes.xlsx");
    });
});

    </script>

<style>
    @keyframes pulsar {
        0% { transform: scale(1); }
        50% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }
    .animando {
        animation: pulsar 1s infinite;
    }
    </style>
@endsection