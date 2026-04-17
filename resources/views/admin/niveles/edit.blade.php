@extends('adminlte::page')

@section('content')
<h1>Editar Nivel</h1>

<form action="{{ route('admin.niveles.update', $nivel->id) }}" method="POST">
    @csrf
    @method('PUT')

    <input type="text" name="nombre" value="{{ $nivel->nombre }}" class="form-control">

    <button class="btn btn-primary mt-2">Actualizar</button>
</form>

@endsection