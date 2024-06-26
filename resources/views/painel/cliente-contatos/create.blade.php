@extends('layouts.layout_principal')
@section('title', 'Adicionar Contato')

@section('content')

<div class="col-md-8 mx-auto align-items-center">
    <div class="card">
        <div class="card-header">
            <h4>Adicionar Contato</h4>
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

            <form action="{{ route('contatos.store')}}" method="post">
                @csrf
                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">Cliente*</label>
                            <select name="cliente_id" class="js-example-basic-single"
                                style="width: 100% !important; max-height: 100px !important" required>
                                <option></option>

                                @foreach ($clientes as $cliente)

                                    <option value="{{$cliente['id']}}">{{$cliente['nome']}}</option>

                                @endforeach

                            </select>
                        </div>
                    </div><!-- Col -->

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">Nome*</label>
                            <input name="nome" type="text" class="form-control" required>
                        </div>
                    </div><!-- Col -->

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label class="control-label">E-mail*</label>
                            <input name="email" type="email" class="form-control" required>
                        </div>
                    </div><!-- Col -->

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label class="control-label">Telefone</label>
                            <input name="telefone" id="telefone" type="text" class="form-control">
                        </div>
                    </div><!-- Col -->


                </div><!-- Row -->

                <button type="submit" class="btn btn-primary d-inline-flex align-items-center mr-2">Salvar<i class="mdi mdi-cloud-upload ml-2"></i></button>
                <a href="{{route('tributacao.index')}}" class="btn btn-light d-inline-flex align-items-center mr-2">Cancelar<i class="mdi mdi-close-circle-outline ml-2"></i></a>
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
