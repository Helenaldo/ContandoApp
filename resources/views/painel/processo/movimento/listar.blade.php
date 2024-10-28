@extends('layouts.layout_principal')
@section('title', 'Movimento do Processo')

@section('content')

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header">

                <h3 class="text-primary">Processo</h3>
                <h6>(Controle interno: {{$processo['tenant']['nome']}})</h6>

            </div>
            <div class="card-body">
                <div>
                    <h6>Cliente: {{$processo['cliente']['nome']}}</h6>
                </div>
                <div>
                    <h6>CPF/CNPJ: {{$processo['cliente']['cpf_cnpj']}}</h6>
                </div><br>

                <div>
                    <h6>Título: {{$processo['id']}} - {{$processo['titulo']}}</h6>
                </div>
                <div>
                    <h6>Número: {{$processo['numero']}} </h6>
                </div>
                <div>
                    <h6>Data: {{ \Carbon\Carbon::parse($processo['data'])->format('d/m/Y') }} </h6>
                </div>
                <div>
                    <h6>Prazo: {{ \Carbon\Carbon::parse($processo['prazo'])->format('d/m/Y')}} </h6>
                </div>
                <div>
                    <h6>Concluído: {{$processo['concluido'] ? $processo['concluido'] : 'Não' }} </h6>
                </div>
                <br>
                <br>


                <div class="row">
                    <div class="col-md-4">
                        <h3 class="text-primary">Movimentos</h3>
                    </div>
                    <div class="col-md-8 text-right">
                        <a href="{{ route('movimento.create') }}?processo_id={{ $processo['id'] }}" type="button" class="btn btn-primary">Novo movimento</a>
                        <a href="javascript:history.back()" type="button" class="btn btn-secondary">Voltar</a>
                    </div>

                </div>



                <div class="table-responsive" style="table-layout: fixed; width: 100%;">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Descrição</th>
                                <th>Anexo</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($processo['movimentos'] as $movimento)

                            <tr>
                                <td>{{\Carbon\Carbon::parse($movimento['data'])->format('d/m/Y')}}</td>
                                <td class="text-wrap" tyle="white-space: normal;"> {{$movimento['descricao']}} </td>

                                @if(isset($movimento['anexo']) && !empty($movimento['anexo']))

                                <td>
                                    <a href="{{ $movimento['anexo'] }}">
                                        <i data-feather="paperclip"></i>
                                    </a>

                                </td>

                                @else
                                <td></td>
                                @endif

                                <td class="acoes-coluna">
                                    <a href="{{route('movimento.edit', $movimento['id'])}}" class="btn btn-warning btn-sm">Editar</a>
                                    <form class="d-inline" action="{{route('movimento.destroy', $movimento['id'])}}" method="POST">
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

@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            // Seleciona todas as tags <li> que têm a classe "active"
            var activeItems = document.querySelectorAll('li.active');

            // Remove a classe "active" de cada <li>
            activeItems.forEach(function(item) {
                item.classList.remove('active');
            });
        }, 100); // Atraso de 100 milissegundos
    });
</script>
@endsection
