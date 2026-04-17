@extends('adminlte::page')

@section('title', 'Periodos')

@section('content_header')
    <h1><b>Periodos académicos</b></h1>
@stop

@section('content')

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Periodos registrados</h3>

                <div class="card-tools">
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalPeriodo">
                        Crear nuevo periodo
                    </button>
                </div>
            </div>

            <div class="card-body">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Nro</th>
                            <th>Gestión</th>
                            <th>Periodo</th>
                            <th style="width: 220px;">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php $contador = 1; @endphp

                        @foreach($gestiones as $gestion)
                            @forelse($gestion->periodos as $periodo)
                                <tr>
                                    @if($loop->first)
                                        <td rowspan="{{ $gestion->periodos->count() }}">{{ $contador }}</td>
                                        <td rowspan="{{ $gestion->periodos->count() }}">{{ $gestion->nombre }}</td>
                                    @endif

                                    <td>
                                     <span class="btn btn-info btn-block">
                                        {{ $periodo->nombre }}
                                    </span>
                                    </td>

                                    <td>
                                        <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalEditar{{ $periodo->id }}">
                                            Editar
                                        </button>

                                        <form id="miFormulario{{ $periodo->id }}" action="{{ route('admin.periodos.destroy', $periodo->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="preguntar{{ $periodo->id }}(event)" class="btn btn-danger btn-sm">
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- MODAL EDITAR -->
                                <div class="modal fade" id="modalEditar{{ $periodo->id }}">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('admin.periodos.update', $periodo->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')

                                                <input type="hidden" name="formulario" value="editar">
                                                <input type="hidden" name="periodo_id" value="{{ $periodo->id }}">

                                                <div class="modal-header bg-success text-white">
                                                    <h5 class="modal-title">Editar periodo</h5>
                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                </div>

                                                <div class="modal-body">
                                                    <label>Gestión (*)</label>
                                                    <select name="gestion_id" class="form-control @error('gestion_id') is-invalid @enderror" required>
                                                        <option value="">Seleccione una gestión</option>
                                                        @foreach(\App\Models\Gestion::orderBy('nombre')->get() as $g)
                                                            <option value="{{ $g->id }}" {{ old('gestion_id', $periodo->gestion_id) == $g->id ? 'selected' : '' }}>
                                                                {{ $g->nombre }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('gestion_id')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror

                                                    <br>

                                                    <label>Nombre del periodo (*)</label>
                                                    <input type="text" name="nombre"
                                                           value="{{ old('nombre', $periodo->nombre) }}"
                                                           class="form-control @error('nombre') is-invalid @enderror"
                                                           required>

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

                                <script>
                                    function preguntar{{ $periodo->id }}(event) {
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
                                                document.getElementById('miFormulario{{ $periodo->id }}').submit();
                                            }
                                        });
                                    }
                                </script>

                            @empty
                                <tr>
                                    <td>{{ $contador }}</td>
                                    <td>{{ $gestion->nombre }}</td>
                                    <td colspan="2"></td>
                                </tr>
                            @endforelse

                            @php $contador++; @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- MODAL CREAR -->
<div class="modal fade" id="modalPeriodo">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.periodos.store') }}" method="POST">
                @csrf

                <input type="hidden" name="formulario" value="crear">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Crear periodo</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <label>Gestión (*)</label>
                    <select name="gestion_id" class="form-control @error('gestion_id') is-invalid @enderror" required>
                        <option value="">Seleccione una gestión</option>
                        @foreach(\App\Models\Gestion::orderBy('nombre')->get() as $gestion)
                            <option value="{{ $gestion->id }}" {{ old('gestion_id') == $gestion->id ? 'selected' : '' }}>
                                {{ $gestion->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('gestion_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror

                    <br>

                    <label>Nombre del periodo (*)</label>
                    <input type="text" name="nombre"
                           value="{{ old('nombre') }}"
                           class="form-control @error('nombre') is-invalid @enderror"
                           required>

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

@if ($errors->any())
<script>
    $(document).ready(function () {
        @if(old('formulario') === 'crear')
            $('#modalPeriodo').modal('show');
        @endif

        @if(old('formulario') === 'editar' && old('periodo_id'))
            $('#modalEditar{{ old('periodo_id') }}').modal('show');
        @endif
    });
</script>
@endif

@stop