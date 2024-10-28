@extends('layouts.layout_principal')
@section('title', 'Usuários')

@section('content')

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex">

    <div class="col-md-6 d-flex align-items-center">
        <a href="{{ route('user.create')}}" type="button" class="btn btn-primary btn-icon d-flex justify-content-center align-items-center mr-2">
            <i data-feather="plus"></i>
        </a>
        <div class="text-primary">
            Adicionar Usuários ({{count($users)}})
        </div>
    </div>
{{-- {{dd($params['ativo'])}} --}}
    <div class="form-group col-md-6 d-flex align-items-center justify-content-end">
        <div class="d-flex align-items-center">
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input
                        type="radio"
                        class="form-check-input"
                        name="ativo"
                        value="1"
                        onchange="sendValue(this)"
                        @checked($params['ativo'] == '1')
                        >
                    Ativos
                    <i class="input-frame"></i>
                </label>
            </div>

            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input
                        type="radio"
                        class="form-check-input"
                        name="ativo"
                        value="0"
                        onchange="sendValue(this)"
                        @checked($params['ativo'] == '0')
                        >
                    Todos
                    <i class="input-frame"></i>
                </label>
            </div>
        </div>
    </div>

</div>

                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table id="dataTableExample" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>E-mail</th>
                                    <th>Status</th>
                                    <th>Ativo</th>
                                    <th class="acoes-coluna">AÇÕES</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr class="{{ $user['ativo'] ? '' : 'table-danger' }}">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if(isset($user['avatar']) && !empty($user['avatar']))

                                                <img src="{{ $user['avatar'] }}" class="rounded-circle mr-2 wd-35" alt="user">
                                            @else
                                                <img src="/assets/images/user-default2.png" class="rounded-circle mr-2 wd-35" alt="user">
                                            @endif
                                            <div>{{ $user['name'] }}</div>
                                        </div>
                                    </td>
                                    <td>{{$user['email']}}</td>
                                    <td>{{$user['status']}}</td>
                                    <td>{{$user['ativo'] ? 'Sim' : 'Não'}}</td>
                                    <td class="acoes-coluna">
                                        <a href="#" class="btn btn-primary btn-sm">Ver</a>
                                        <a href="{{route('user.edit', $user['id'])}}" class="btn btn-warning btn-sm">Editar</a>
                                        <form class="d-inline" action="{{route('user.destroy', $user['id'])}}" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja excluir este usuário?')">Desativar</button>
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
{{-- Filtro Ativo/Inativo --}}
<script>
    function sendValue(radio) {
        const value = radio.value;
        window.location.href = `{{ url('user') }}?ativo=${value}`;
    }
</script>
{{-- Fim do Filtro Ativo/Inativo --}}

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
