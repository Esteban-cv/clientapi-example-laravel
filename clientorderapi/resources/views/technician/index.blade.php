@extends('templates.base')
@section('title','Técnicos')
@section('header', 'Técnicos')
@section('content')

    <div class="row">
        <div class="col-lg-12 mb-4 d-grid gap-2 d-md-block">
            <a href="{{ route('technician.create') }}" class="btn btn-primary">Crear</a>
        </div>
    </div>    
    
    @include('templates.messages')

    <div class="row">
        <div class="col-lg-12 mb-4">
            <table id="table_data" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Documento</th>
                        <th>Nombre</th>
                        <th>Especialización</th>
                        <th>Teléfono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <body>
                    @foreach($technicians as $technician)
                    <tr>
                        <td>{{ $technician['id'] }}</td>
                        <td>{{ $technician['document'] }}</td>
                        <td>{{ $technician['name'] }}</td>
                        <td>{{ $technician['speciality'] ?? 'N/A'}}</td>
                        <td>{{ $technician['phone'] }}</td>
                        <td>
                            
                            <a href="{{ route('technician.edit',$technician['id']) }}" class="btn btn-primary btn-circle btn-sm" title="Editar"><i class="far fa-edit"></i>
                            </a>
                            <a href="{{ route('technician.destroy',$technician['id']) }}" class="btn btn-danger btn-circle btn-sm" class="Eliminar" onclick="return remove();"><i class="fa-solid fa-trash-can"></i>
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