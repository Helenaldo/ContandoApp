@extends('layouts.layout_principal')
@section('title', 'Clientes')

@section('content')

    <div class="row align-items-center">
        <div class="col-md-12 grid-margin stretch-card align-items-center">
            <div class="card">
                <div class="card-body">
                    <div class="row ">

                        <div class="col-md-3 d-flex align-items-center text-primary">
                            <a href="{{ route( 'clientes.create')}}" type="button" class="btn btn-primary btn-icon d-flex justify-content-center align-items-center mr-2">
                                <i data-feather="plus"></i>
                            </a>
                            <div>
                            Total : 155
                            </div>
                        </div>

                        <div class="col-md-3 text-primary">
                            <i data-feather="check-circle" class="mr-2"></i>Lucro Presumido: 87
                        </div>

                        <div class="col-md-3 text-primary">
                            <i data-feather="check-circle" class="mr-2"></i>Lucro Real: 11
                        </div>

                        <div class="col-md-3 text-primary">
                            <i data-feather="check-circle" class="mr-2"></i>Simples Nacional: 87
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">


                    <h6 class="card-title">Meus Clentes</h6>
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Nome de Fantasia</th>
                                    <th>CNPJ/CPF</th>
                                    <th class="acoes-coluna">AÇÕES</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clientes as $cliente)
                                <tr>
                                    <td>{{$cliente['nome']}}</td>
                                    <td>{{$cliente['fantasia']}}</td>
                                    <td>{{$cliente['cpf_cnpj']}}</td>
                                    <td class="acoes-coluna">
                                        <a href="{{route('clientes.show', $cliente['id'])}}" class="btn btn-primary btn-sm">Ver</a>
                                        <a href="{{route('clientes.edit', $cliente['id'])}}" class="btn btn-warning btn-sm">Editar</a>
                                        <a href="{{route('clientes.destroy', $cliente['id'])}}" class="btn btn-danger btn-sm">Excluir</a>
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
        min-width: 180px; /* Garante que a coluna não encolha abaixo desse tamanho */
        max-width: 180px; /* Garante que a coluna não cresça acima desse tamanho */
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
