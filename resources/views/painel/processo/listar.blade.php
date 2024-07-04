@extends('layouts.layout_principal')
@section('title', 'Processos')

@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <div class="col-md-3 d-flex align-items-center text-primary">
                        <a href="{{ route( 'processo.create' )}}" type="button" class="btn btn-primary btn-icon d-flex justify-content-center align-items-center mr-2">
                            <i data-feather="plus"></i>
                        </a>
                        <div>
                        Adicionar Processo ({{count($processos)}})
                        </div>
                    </div>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table id="dataTableExample" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Processo nº</th>
                                    <th>Título</th>
                                    <th>Início</th>
                                    <th>Status</th>
                                    <th>Responsável</th>
                                    <th class="acoes-coluna">AÇÕES</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($processos as $processo)
                                @php
                                    // Calcular o status (Em dia, Atrasado)
                                    $prazo = \Carbon\Carbon::parse($processo['prazo']);
                                    $status = $prazo->greaterThanOrEqualTo(\Carbon\Carbon::now()) ? 'Em dia' : 'Atrasado';
                                @endphp
                                <tr>
                                    <td>{{$processo['cliente']['nome']}}</td>
                                    <td>{{$processo['numero']}}</td>
                                    <td>{{$processo['titulo']}}</td>
                                    <td>{{ \Carbon\Carbon::parse($processo['data'])->format('d/m/Y') }}</td>
                                    <td>{{  $status }}</td>
                                    <td>{{ explode(' ', $processo['user']['name'])[0] }}</td>
                                    <td class="acoes-coluna">
                                        <a href="{{ route('processo.show', $processo['id']) }}" class="btn btn-primary btn-sm">Ver</a>
                                        <a href="{{route('processo.edit', $processo['id'])}}" class="btn btn-warning btn-sm">Editar</a>
                                        <form class="d-inline" action="{{route('processo.destroy', $processo['id'])}}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este processo?')">Excluir</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>




@endsection

@section('css')
<link rel="stylesheet" href="/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
<link rel="stylesheet" href="/assets/vendors/sweetalert2/sweetalert2.min.css">
<Style>
    .acoes-coluna {
        width: 180px; /* Ajuste o valor conforme necessário */
    }
</Style>
@endsection

@section('js')
<script src="/assets/vendors/datatables.net/jquery.dataTables.js"></script>
<script src="/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
<script src="/assets/js/data-table.js"></script>

{{-- Início Switch-Alert --}}
<script src="/assets/vendors/sweetalert2/sweetalert2.min.js"></script>
<script src="/assets/js/sweet-alert-custom.js"></script>
@php
    $alertTypes = [
        'success' => 'success',
        'error' => 'error',
        'info' => 'info',
        'warning' => 'warning',
    ];
@endphp

@foreach ($alertTypes as $key => $type)
    @if (session($key))
    <script>
        showSwal('custom-position', '{{ $type }}', '{{ session($key) }}');
    </script>
    @endif
@endforeach
{{-- Fim Switch-Alert --}}



@endsection
