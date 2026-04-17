@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Grado</h1>
    <form action="{{ route('grados.update', $grado) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nombre">Nombre</label>
            <input type="text" name="nombre" class="form-control" value="{{ $grado->nombre }}" required>
        </div>
        <div class="form-group">
            <label for="nivel_id">Nivel</label>
            <select name="nivel_id" class="form-control" required>
                @foreach ($niveles as $nivel)
                <option value="{{ $nivel->id }}" {{ $grado->nivel_id == $nivel->id ? 'selected' : '' }}>{{ $nivel->nombre }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-success">Actualizar</button>
    </form>
</div>
@endsection
