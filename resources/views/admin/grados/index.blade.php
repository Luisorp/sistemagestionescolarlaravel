@extends('adminlte::page')

@section('content_header')
    <h1><b>Listado de grados</b></h1>
    <hr>
@stop

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card card-outline card-primary">

            <!-- HEADER -->
            <div class="card-header">
                <h3 class="card-title">Grados registrados</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalCreate">
                        Crear nuevo grado
                    </button>
                </div>
            </div>

            <!-- MODAL CREATE -->
            <div class="modal fade" id="ModalCreate" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <div class="modal-header" style="background-color:#007bff;color:white;">
                            <h5 class="modal-title">Registro de un nuevo grado</h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <form action="{{ url('/admin/grados/create') }}" method="POST">
                                @csrf

                                <!-- NIVEL -->
                                <div class="form-group">
                                    <label>Niveles</label><b> (*)</b>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-layer-group"></i></span>
                                        </div>
                                        <select class="form-control" name="nivel_id_create" required>
                                            <option value="">Seleccione un nivel</option>
                                            @foreach ($niveles as $nivel)
                                                <option value="{{ $nivel->id }}">{{ $nivel->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('nivel_id_create')
                                        <small style="color:red">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- NOMBRE -->
                                <div class="form-group">
                                    <label>Nombre del grado</label><b> (*)</b>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-list-alt"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="nombre_create"
                                               value="{{ old('nombre_create') }}"
                                               placeholder="Escriba aquí ..." required>
                                    </div>
                                    @error('nombre_create')
                                        <small style="color:red">{{ $message }}</small>
                                    @enderror
                                </div>

                                <hr>

                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-primary">Guardar</button>
                                </div>

                            </form>
                        </div>

                    </div>
                </div>
            </div>

            <!-- TABLA -->
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover table-sm">
                    <thead>
                        <tr>
                            <th>Nro</th>
                            <th>Niveles</th>
                            <th>Grados</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($niveles as $nivel)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $nivel->nombre }}</td>

                            <!-- GRADOS -->
                            <td>
                                @foreach ($nivel->grados as $grado)
                                    <button class="btn btn-info btn-sm btn-block">{{ $grado->nombre }}</button>
                                @endforeach
                            </td>

                            <td>
                                @foreach ($nivel->grados as $grado)
                                    <div class="d-flex justify-content-center mb-1">

                            
                                        <button type="button" class="btn btn-success btn-sm mr-1" data-toggle="modal" data-target="#ModalUpdate{{ $grado->id }}">
                                            <i class="fas fa-pencil-alt"></i> Editar
                                        </button>

                                
                                        <form action="{{ url('/admin/grados/' . $grado->id) }}" method="POST" id="form{{ $grado->id }}">
                                            @csrf
                                            @method('DELETE')
                                    
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="confirmar{{ $grado->id }}(event)">
                                                <i class="fas fa-trash"></i> Eliminar
                                            </button>
                                        </form>

                                    </div>

                                    <!-- SCRIPT ELIMINAR -->
                                    <script>
                                        function confirmar{{ $grado->id }}(e) {
                                            e.preventDefault();
                                            Swal.fire({
                                                title: '¿Eliminar registro?',
                                                icon: 'question',
                                                showDenyButton: true,
                                                confirmButtonText: 'Eliminar',
                                                denyButtonText: 'Cancelar'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    document.getElementById('form{{ $grado->id }}').submit();
                                                }
                                            });
                                        }
                                    </script>

                                    <!-- MODAL UPDATE -->
                                    <div class="modal fade" id="ModalUpdate{{ $grado->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">

                                                <div class="modal-header" style="background-color:#08a35b;color:white;">
                                                    <h5 class="modal-title">Editar grado</h5>
                                                    <button type="button" class="close" data-dismiss="modal">
                                                        <span>&times;</span>
                                                    </button>
                                                </div>

                                                <div class="modal-body">
                                                    <form action="{{ url('/admin/grados/' . $grado->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')

                                                        <!-- NIVEL -->
                                                        <div class="form-group">
                                                            <label>Niveles</label><b> (*)</b>
                                                            <select class="form-control" name="nivel_id" required>
                                                                @foreach ($niveles as $nivel)
                                                                    <option value="{{ $nivel->id }}" {{ $nivel->id == $grado->nivel_id ? 'selected' : '' }}>
                                                                        {{ $nivel->nombre }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <!-- NOMBRE -->
                                                        <div class="form-group">
                                                            <label>Nombre del grado</label><b> (*)</b>
                                                            <input type="text" class="form-control" name="nombre"
                                                                   value="{{ old('nombre', $grado->nombre) }}" required>
                                                        </div>

                                                        <hr>

                                                        <div class="d-flex justify-content-between">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                            <button type="submit" class="btn btn-success">Actualizar</button>
                                                        </div>

                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                @endforeach
                            </td>

                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@stop

@section('css')
{{-- estilos extra --}}
@stop

@section('js')
@if ($errors->any())
<script>
    $(function() {
        @if (session('modal_id'))
            $('#ModalUpdate{{ session('modal_id') }}').modal('show');
        @else
            $('#ModalCreate').modal('show');
        @endif
    });
</script>
@endif
@stop