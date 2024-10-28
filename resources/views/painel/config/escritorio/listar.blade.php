@extends('layouts.layout_principal')
@section('title', 'Meu Escritório')

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header">
                <h4>Escritório</h4>
            </div>
            <div class="card-body">

                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-sm-6"><b>Nome: </b>{{$tenant[0]['nome']}}  </div>
                            <div class="col-sm-4"><b>CNPJ/CPF: </b>{{$tenant[0]['cnpj_cpf']}}  </div>
                            <div class="col-sm-2"><b>Contrato: </b>{{$tenant[0]['contrato']}}  </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-sm-4"><b>Logradouro: </b>{{$tenant[0]['logradouro']}}  </div>
                            <div class="col-sm-2"><b>Número: </b>{{$tenant[0]['numero']}}  </div>
                            <div class="col-sm-3"><b>Bairro: </b>{{$tenant[0]['numero']}}  </div>
                            <div class="col-sm-3"><b>Complemento: </b>{{$tenant[0]['bairro']}}  </div>
                            <div class="col-sm-4"><b>Cidade: </b>{{$tenant[0]['cidade']['municipio']}} - {{$tenant[0]['cidade']['UF']}}  </div>
                            <div class="col-sm-4"><b>CEP: </b>{{$tenant[0]['cep']}}  </div>
                        </div>
                    </li>

                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-sm-6"><b>Telefone: </b>{{$tenant[0]['telefone']}}  </div>
                            <div class="col-sm-6"><b>E-mail: </b>{{$tenant[0]['email']}}  </div>

                        </div>
                    </li>

                    <li class="list-group-item">
                        <div class="row">
                                <div class="col-sm-4">
                                    <a href="#">
                                        <b>Quantidade de Clientes: </b>{{count($tenant[0]['clientes'])}}
                                    </a>
                                </div>

                                <div class="col-sm-4">
                                    <a href="#">
                                        <b>Quantidade de Processos: </b>{{count($tenant[0]['processos'])}}
                                    </a>
                                </div>

                                <div class="col-sm-4">
                                    <a href="#">
                                        <b>Quantidade de Usuários: </b>{{count($tenant[0]['users'])}}
                                    </a>
                                </div>


                        </div>
                    </li>
                </ul>
                <div class="row">
                    <div class="col-sm-12">
                        <a href="{{route('tenant.edit')}}" class="btn btn-warning btn-sm">Alterar</a>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
@endsection

