@extends('layouts.layout_principal')
@section('title', 'Adicionar Processo')

@section('content')

<div class="col-md-8 mx-auto align-items-center">
    <div class="card">
        <div class="card-header">
            <h4>Novo Processo</h4>
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

            <form action="{{ route('processo.store')}}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="row">

                    <div class="col-sm-6">
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
                    </div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label">Título*</label>
                            <input name="titulo" type="text" class="form-control" required>
                        </div>
                    </div><!-- Col -->

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label">Número do Processo</label>
                            <input name="numero" type="text" class="form-control">
                        </div>
                    </div><!-- Col -->
                </div><!-- Row -->

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">Início*</label>
                            <input name="data" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" type="date" class="form-control" required>
                        </div>
                    </div><!-- Col -->

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">Prazo</label>
                            <input name="prazo" type="date" class="form-control">
                        </div>
                    </div><!-- Col -->

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">Responsável*</label>
                            <select name="user_id" class="form-control" required>
                                <option selected="" disabled="">Selecione...</option>
                                @foreach ($users as $user)
                                <option value="{{$user['id']}}" @selected(session('authenticated')['user']['id'] === $user['id'])>{{$user['name']}}</option>
                                @endforeach

                            </select>
                        </div>
                    </div><!-- Col -->

                </div><!-- Row -->

                <button type="submit" class="btn btn-primary d-inline-flex align-items-center mr-2">Salvar<i class="mdi mdi-cloud-upload ml-2"></i></button>
                <a href="{{route('processo.index')}}" class="btn btn-light d-inline-flex align-items-center mr-2">Cancelar<i class="mdi mdi-close-circle-outline ml-2"></i></a>
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
<script src="/assets/vendors/select2/select2.min.js"></script>
<script src="/assets/js/select2.js"></script>
@endsection
