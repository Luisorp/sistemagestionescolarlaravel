@extends('adminlte::page')

@section('title', 'Niveles')

@section('content_header')
    <h1><b>Niveles</b></h1>
@stop

@section('content')

<div class="row">

    <div class="col-md-6">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Niveles Registrados</h3>

                <div class="card-tools">
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalNivel">
                        Crear nuevo nivel
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
                        @foreach($niveles as $nivel)
                        <tr>
                            <td>{{ $nivel->id }}</td>
                            <td>{{ $nivel->nombre }}</td>
                            <td>

                                <!-- BOTON EDITAR -->
                                <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalEditar{{ $nivel->id }}">
                                    Editar
                                </button>

                                <!-- ELIMINAR -->
                                <form id="miFormulario{{ $nivel->id }}" action="{{ route('admin.niveles.destroy', $nivel->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')

                                    <button onclick="preguntar{{ $nivel->id }}(event)" class="btn btn-danger btn-sm">
                                        Eliminar
                                    </button>
                                </form>

                            </td>
                        </tr>

                        <!-- MODAL EDITAR -->
                        <div class="modal fade" id="modalEditar{{ $nivel->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <form action="{{ route('admin.niveles.update', $nivel->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="modal-header bg-success text-white">
                                            <h5 class="modal-title">Editar nivel</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>

                                        <div class="modal-body">
                                            <label>Nombre del nivel (*)</label>
                                            <input type="text" name="nombre"
       value="{{ old('nombre', $nivel->nombre) }}"
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

                        <!-- SCRIPT SWEETALERT -->
                        <script>
                        function preguntar{{ $nivel->id }}(event) {
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
                                    document.getElementById('miFormulario{{ $nivel->id }}').submit();
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
<div class="modal fade" id="modalNivel">
    <div class="modal-dialog">
        <div class="modal-content">

            <form action="{{ route('admin.niveles.store') }}" method="POST">
                @csrf

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Crear Nivel</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <label>Nombre del nivel</label>
                    <input type="text" name="nombre"
       value="{{ old('nombre', $nivel->nombre) }}"
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