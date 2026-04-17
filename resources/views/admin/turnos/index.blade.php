@extends('adminlte::page')

@section('title', 'Turnos')

@section('content_header')
    <h1><b>Turnos</b></h1>
@stop

@section('content')

<div class="row">

    <div class="col-md-6">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Turnos Registrados</h3>

                <div class="card-tools">
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTurno">
                        Crear nuevo turno
                    </button>
                </div>
            </div>

            <div class="card-body">

                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Nro</th>
                            <th>Nombre</th>
                            <th style="width: 300px;">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($turnos as $turno)
                        <tr>
                            <td>{{ $turno->id }}</td>
                            <td>{{ $turno->nombre }}</td>
                            <td>

                                <!-- EDITAR -->
                                <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalEditar{{ $turno->id }}">
                                    Editar
                                </button>

                                <!-- ELIMINAR -->
                                <form id="miFormulario{{ $turno->id }}" action="{{ route('admin.turnos.destroy', $turno->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')

                                    <button onclick="preguntar{{ $turno->id }}(event)" class="btn btn-danger btn-sm">
                                        Eliminar
                                    </button>
                                </form>

                            </td>
                        </tr>

                        <!-- MODAL EDITAR -->
                        <div class="modal fade" id="modalEditar{{ $turno->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <form action="{{ route('admin.turnos.update', $turno->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="modal-header bg-success text-white">
                                            <h5 class="modal-title">Editar turno</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>

                                        <div class="modal-body">
                                            <label>Nombre del turno (*)</label>
                                            <input type="text" name="nombre"
                                                value="{{ old('nombre', $turno->nombre) }}"
                                                class="form-control @error('nombre') is-invalid @enderror">

                                            @error('nombre')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                            <button class="btn btn-success">Actualizar</button>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>

                        <!-- SWEETALERT -->
                        <script>
                        function preguntar{{ $turno->id }}(event) {
                            event.preventDefault();

                            Swal.fire({
                                title: '¿Desea eliminar este registro?',
                                icon: 'question',
                                showDenyButton: true,
                                confirmButtonText: 'Eliminar',
                                confirmButtonColor: '#a5161d',
                                denyButtonColor: '#270a0a',
                                denyButtonText: 'Cancelar',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    document.getElementById('miFormulario{{ $turno->id }}').submit();
                                }
                            });
                        }
                        </script>

                        @endforeach
                    </tbody>

                </table>

            </div>
        </div>

    </div>

</div>

<!-- MODAL CREAR -->
<div class="modal fade" id="modalTurno">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="{{ route('admin.turnos.store') }}" method="POST">
                @csrf

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Crear Turno</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <label>Nombre del turno</label>
                    <input type="text" name="nombre"
                        value="{{ old('nombre') }}"
                        class="form-control @error('nombre') is-invalid @enderror">

                    @error('nombre')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>

            </form>

        </div>
    </div>
</div>

@stop