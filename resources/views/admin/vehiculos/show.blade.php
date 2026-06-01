@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">Detalle: {{ $vehiculo->modelo }}</h5>
            </div>
            <div class="card-body text-center">
                @if($vehiculo->foto)
                    <img src="{{ asset('storage/' . $vehiculo->foto) }}" class="img-fluid rounded mb-3" style="max-height:300px">
                @else
                    <div class="bg-light p-4 rounded mb-3 text-muted">Sin imagen disponible</div>
                @endif
                <table class="table table-bordered text-start">
                    <tr><th>Modelo</th><td>{{ $vehiculo->modelo }}</td></tr>
                    <tr><th>Marca</th><td>{{ $vehiculo->marca->nombre }} ({{ $vehiculo->marca->pais_origen }})</td></tr>
                    <tr><th>Año</th><td>{{ $vehiculo->anio }}</td></tr>
                    <tr><th>Precio</th><td>S/. {{ number_format($vehiculo->precio, 2) }}</td></tr>
                    <tr><th>Kilometraje</th><td>{{ number_format($vehiculo->kilometraje) }} km</td></tr>
                </table>
                <a href="{{ route('admin.vehiculos.index') }}" class="btn btn-secondary">← Volver</a>
            </div>
        </div>
    </div>
</div>
@endsection