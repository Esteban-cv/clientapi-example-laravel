@extends('templates.base')
@section('title','Actividades')
@section('header', 'Actividades')
@section('content')

    <div class="row">
        <div class="col-lg-12 mb-4 d-grid gap-2 d-md-block">
            <a href="{{ route('activity.create') }}" class="btn btn-primary">Crear</a>
        </div>
    </div>    
    
    @include('templates.messages')

    <div class="row">
        <div class="col-lg-12 mb-4">
            <table id="table_data" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Descripción</th>
                        <th>Horas</th>
                        <th>técnico</th>
                        <th>tipo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <body>
                    @foreach($activities as $activity)
                    <tr>
                        <td>{{ $activity['id'] }}</td>
                        <td>{{ $activity['description'] }}</td>
                        <td>{{ $activity['hours'] }}</td>
                        <td>{{ $activity['technician']['document'] }} - {{ $activity['technician']['name'] }}</td>
                        <td>{{ $activity['type_activity']['description'] }}</td>
                        <td>
                            <a href="{{ route('activity.edit',$activity['id']) }}" class="btn btn-primary btn-circle btn-sm" title="Editar"><i class="far fa-edit"></i>
                            </a>
                            <a href="{{ route('activity.destroy',$activity['id']) }}" class="btn btn-danger btn-circle btn-sm" class="Eliminar" onclick="return remove();"><i class="fa-solid fa-trash-can"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </body>
            </table>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('js/general.js') }}"></script>
@endsection