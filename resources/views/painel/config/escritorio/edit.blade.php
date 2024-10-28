@extends('layouts.layout_principal')
@section('title', 'Alterar dados do Escritório')

@section('content')

<div class="col-md-8 mx-auto align-items-center">
    <div class="card">
        <div class="card-header">
            <h4>Alterar dados do Escritório</h4>
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


        <form action="{{ route('tenant.update') }}" method="POST">
            @method('put')
            @csrf
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label">Nome</label>
                            <input type="text" name="nome" value="{{$tenant[0]['nome']}}" class="form-control">
                        </div>
                    </div><!-- Col -->

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">CNPJ/CPF</label>
                            <input type="text" value="{{$tenant[0]['cnpj_cpf']}}" class="form-control" disabled>
                        </div>
                    </div><!-- Col -->

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label class="control-label">Contrato</label>
                            <input type="text" value="{{$tenant[0]['contrato']}}" class="form-control" disabled>
                        </div>
                    </div><!-- Col -->
                </div><!-- Row -->

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">Logradouro</label>
                            <input type="text" name="logradouro" value="{{$tenant[0]['logradouro']}}" class="form-control" required>
                        </div>
                    </div><!-- Col -->

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label class="control-label">Número</label>
                            <input type="text" name="numero" value="{{$tenant[0]['numero']}}" class="form-control" required>
                        </div>
                    </div><!-- Col -->

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label class="control-label">Bairro</label>
                            <input type="text" name="bairro" value="{{$tenant[0]['bairro']}}" class="form-control" required>
                        </div>
                    </div><!-- Col -->
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">Complemento</label>
                            <input type="text" name="complemento" value="{{$tenant[0]['complemento']}}" class="form-control">
                        </div>
                    </div><!-- Col -->
                </div><!-- Row -->

                <div class="row">
                    <div class="col-sm-3">

                        <div class="form-group">
                            <label class="control-label">Cidade</label>
                            <input type="hidden" id="cidade" value="">
                            <input type="hidden" id="uf" value="">
                            <select name="cidade_id" id="cidade_id" class="js-example-basic-single"
                                style="width: 100% !important; max-height: 100px !important">
                                <option></option>

                                @foreach ($cidades as $cidade)

                                    <option value="{{$cidade['id']}}" @selected($cidade['id'] === $tenant[0]['cidade']['id'])>{{$cidade['nome']}}</option>

                                @endforeach

                            </select>
                        </div>

                    </div><!-- Col -->

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label">Telefone</label>
                            <input type="text" value="{{$tenant[0]['telefone']}}" class="form-control" disabled>
                        </div>
                    </div><!-- Col -->

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label">E-mail</label>
                            <input type="text" value="{{$tenant[0]['email']}}" class="form-control" disabled>
                        </div>
                    </div><!-- Col -->
                    <div class="form-group col-sm-3">
                        <label>Logo</label>
                        <input type="file" name="logo" class="file-upload-default">
                        <div class="input-group">
                            <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload da Imagem">
                            <span class="input-group-append">
                                <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                            </span>
                        </div>
                    </div>
                </div><!-- Row -->


                <button type="submit" class="btn btn-primary d-inline-flex align-items-center mr-2">Salvar<i class="mdi mdi-cloud-upload ml-2"></i></button>
                <a href="{{route('tenant.listar')}}" class="btn btn-light d-inline-flex align-items-center mr-2">Cancelar<i class="mdi mdi-close-circle-outline ml-2"></i></a>
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
<script src="/assets/js/file-upload.js"></script>
@endsection
