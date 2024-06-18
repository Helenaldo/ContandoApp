@extends('layouts.layout_principal')
@section('title', 'Adicionar Clientes')

@section('content')

<div class="col-md-8 mx-auto align-items-center">
    <div class="card">
        <div class="card-header">
            <h4>Alterar Cliente</h4>
        </div>
        <div class="card-body">

        @if (!empty($errors))
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors as $error)
                        @if (is_array($error))
                            @foreach ($error as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        @else
                            <li>{{ $error }}</li>
                        @endif
                    @endforeach
                </ul>
            </div>
        @endif

            <form action="{{ route('clientes.update', ['cliente' => $cliente['id'] ])}}" method="POST">
                @method('put')
                @csrf

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">Tipo de identificação*</label>
                            <select id="tipo_identificacao" disabled class="form-control">
                                <option selected="">Selecione...</option>
                                <option value="CNPJ" @selected($cliente['tipo_identificacao'] === 'CNPJ')>Pessoa Jurídica</option>
                                <option value="CPF" @selected($cliente['tipo_identificacao'] === 'CPF')>Pessoa Física</option>
                            </select>
                        </div>
                    </div><!-- Col -->
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label" id="cnpjCpfLabel">CNPJ/CPF*</label>
                            <input disabled id='cnpj_cpf' value="{{ $cliente['cpf_cnpj'] }}" type="text" class="form-control">
                        </div>
                    </div><!-- Col -->
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">Tipo de estabelecimento</label>
                            <select name="tipo" class="form-control">
                                <option selected="" disabled="">Selecione...</option>
                                <option value="Matriz" @selected($cliente['tipo'] === 'Matriz')>Matriz</option>
                                <option value="Filial" @selected($cliente['tipo'] === 'Filial')>Filial</option>
                            </select>
                        </div>
                    </div><!-- Col -->
                </div><!-- Row -->
                    <div class="row">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label class="control-label">Nome*</label>
                            <input name="nome" value="{{ $cliente['nome'] }}" type="text" class="form-control">
                        </div>
                    </div><!-- Col -->
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">Nome de Fantasia</label>
                            <input name="fantasia" value="{{ $cliente['fantasia'] }}" type="text" class="form-control">
                        </div>
                    </div><!-- Col -->
                </div><!-- Row -->
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label">CEP</label>
                            <input name="cep" id="cep" value="{{ $cliente['cep'] }}" onblur="pesquisacep(this.value);" type="text" class="form-control">
                        </div>
                    </div><!-- Col -->
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label">Logradouro</label>
                            <input name="logradouro" id="logradouro" value="{{ $cliente['logradouro'] }}" type="text" class="form-control">
                        </div>
                    </div><!-- Col -->
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label">Número</label>
                            <input name="numero" value="{{ $cliente['numero'] }}" type="text" class="form-control">
                        </div>
                    </div><!-- Col -->
                </div><!-- Row -->
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">Bairro</label>
                            <input name="bairro" id="bairro" value="{{ $cliente['bairro'] }}" type="text" class="form-control">
                        </div>
                    </div><!-- Col -->
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">Complemento</label>
                            <input name="complemento" value="{{ $cliente['complemento'] }}" type="text" class="form-control">
                        </div>
                    </div><!-- Col -->
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">Cidade</label>
                            <input type="hidden" id="cidade" value="">
                            <input type="hidden" id="uf" value="">
                            <select name="cidade_id" id="cidade_id" class="js-example-basic-single"
                                style="width: 100% !important; max-height: 100px !important">
                                <option></option>

                                @foreach ($cidades as $cidade)

                                    <option value="{{$cidade['id']}}" @selected($cidade['id'] === $cliente['cidade_id'])>{{$cidade['nome']}}</option>

                                @endforeach

                            </select>
                        </div>
                    </div><!-- Col -->
                </div><!-- Row -->

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label">Cliente desde</label>
                            <input name="data_entrada" value="{{ $cliente['data_entrada'] }}" type="date" class="form-control">
                        </div>
                    </div><!-- Col -->
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label">Distrato</label>
                            <input name="data_saida" value="{{ $cliente['data_saida'] }}" type="date" class="form-control">
                        </div>
                    </div><!-- Col -->
                </div><!-- Row -->

                <button type="submit" class="btn btn-primary d-inline-flex align-items-center mr-2">Salvar<i class="mdi mdi-cloud-upload ml-2"></i></button>
                <a href="{{route('clientes.index')}}" class="btn btn-light d-inline-flex align-items-center mr-2">Cancelar<i class="mdi mdi-close-circle-outline ml-2"></i></a>
            </form>

        </div>
    </div>

</div>

@endsection


@section('css')
<link rel="stylesheet" href="/assets/vendors/select2/select2.min.css">
<style>
    .select2-selection__rendered {
        line-height: 35px !important;

    }

    .select2-container .select2-selection--single {
        height: 35px !important;
        border: 1px solid;
        border-color: #e8ebf1;
        border-radius: 3%;
    }

    .select2-selection__arrow {
        /* height: 35px !important; */
        display: none;

    }
</style>
@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script src="/assets/js/mascaras.js"></script>
<script src="/assets/vendors/select2/select2.min.js"></script>
<script src="/assets/js/select2.js"></script>
<script src="/assets/js/cep.js"></script>
@endsection
