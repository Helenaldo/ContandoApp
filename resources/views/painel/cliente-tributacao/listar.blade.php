@extends('layouts.layout_principal')
@section('title', 'Tributação de Clientes')

@section('content')

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <div class="col-md-3 d-flex align-items-center text-primary">
                        <a href="{{ route('tributacao.create') }}" type="button" class="btn btn-primary btn-icon d-flex justify-content-center align-items-center mr-2">
                            <i data-feather="plus"></i>
                        </a>
                        <div>
                        Adicionar Tributação ({{count($tributacoes)}})
                        </div>
                    </div>
                </div>

                <div class="card-body">


                    <ul class="nav nav-tabs mb-3">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('clientes.index')}}">Meus Clentes</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('tributacao.index')}}">Tributação</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('contatos.index')}}">Contatos</a>
                        </li>

                    </ul>

                    <div class="table-responsive">
                        <table id="dataTableExample" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Tributação</th>
                                    <th>Data</th>
                                    <th class="acoes-coluna">AÇÕES</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tributacoes as $tributacao)
                                <tr>
                                    <td>{{$tributacao['cliente']['nome']}}</td>
                                    <td>{{$tributacao['tipo']}}</td>
                                    <td>{{\Carbon\Carbon::parse($tributacao['data'])->format('d/m/Y')}}</td>
                                    <td class="acoes-coluna">
                                        <a href="#" class="btn btn-primary btn-sm">Ver</a>
                                        <a href="{{route('tributacao.edit', $tributacao['id'])}}" class="btn btn-warning btn-sm">Editar</a>
                                        <form class="d-inline" action="{{route('tributacao.destroy', $tributacao['id'])}}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este cliente?')">Excluir</button>
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
<Style>
    .acoes-coluna {
        width: 180px; /* Ajuste o valor conforme necessário */
    }
</Style>
<link rel="stylesheet" href="/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
<link rel="stylesheet" href="/assets/vendors/sweetalert2/sweetalert2.min.css">
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
