@extends('layouts.layout_principal')
@section('title', 'Adicionar Clientes')

@section('content')

<div class="col-md-8 mx-auto align-items-center">
    <div class="card">
        <div class="card-header">
            <h4>Adicionar Clientes</h4>
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

            <form action="{{ route('clientes.store')}}" method="post">
                @csrf
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">Tipo de identificação*</label>
                            <select name="tipo_identificacao" id="tipo_identificacao" class="form-control">
                                <option selected="" disabled="">Selecione...</option>
                                <option value="CNPJ">Pessoa Jurídica</option>
                                <option value="CPF">Pessoa Física</option>
                            </select>
                        </div>
                    </div><!-- Col -->
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label" id="cnpjCpfLabel">CNPJ/CPF*</label>
                            <input name="cpf_cnpj" id='cnpj_cpf' value="{{ old('cpf_cnpj') }}" type="text" class="form-control">
                        </div>
                    </div><!-- Col -->
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">Tipo de estabelecimento</label>
                            <select name="tipo" class="form-control">
                                <option selected="" disabled="">Selecione...</option>
                                <option value="Matriz">Matriz</option>
                                <option value="Filial">Filial</option>
                            </select>
                        </div>
                    </div><!-- Col -->
                </div><!-- Row -->
                    <div class="row">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label class="control-label">Nome*</label>
                            <input name="nome" value="{{ old('nome') }}" type="text" class="form-control">
                        </div>
                    </div><!-- Col -->
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">Nome de Fantasia</label>
                            <input name="fantasia" value="{{ old('fantasia') }}" type="text" class="form-control">
                        </div>
                    </div><!-- Col -->
                </div><!-- Row -->
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label">CEP</label>
                            <input name="cep" id="cep" value="{{ old('cep') }}" onblur="pesquisacep(this.value);" type="text" class="form-control">
                        </div>
                    </div><!-- Col -->
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label">Logradouro</label>
                            <input name="logradouro" id="logradouro" value="{{ old('logradouro') }}" type="text" class="form-control">
                        </div>
                    </div><!-- Col -->
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label">Número</label>
                            <input name="numero" value="{{ old('numero') }}" type="text" class="form-control">
                        </div>
                    </div><!-- Col -->
                </div><!-- Row -->
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">Bairro</label>
                            <input name="bairro" id="bairro" value="{{ old('bairro') }}" type="text" class="form-control">
                        </div>
                    </div><!-- Col -->
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">Complemento</label>
                            <input name="complemento" value="{{ old('complemento') }}" type="text" class="form-control">
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

                                    <option value="{{$cidade['id']}}">{{$cidade['nome']}}</option>

                                @endforeach

                            </select>
                        </div>
                    </div><!-- Col -->
                </div><!-- Row -->

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label">Cliente desde</label>
                            <input name="data_entrada" type="date" class="form-control">
                        </div>
                    </div><!-- Col -->
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label">Distrato</label>
                            <input name="data_saida" type="date" class="form-control">
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
