@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Agregar Grado</h1>
    <form action="{{ route('grados.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="nivel_id">Nivel</label>
            <select name="nivel_id" class="form-control" required>
                @foreach ($niveles as $nivel)
                <option value="{{ $nivel->id }}">{{ $nivel->nombre }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
    </form>
</div>
@endsection
