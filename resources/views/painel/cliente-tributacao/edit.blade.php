@extends('layouts.layout_principal')
@section('title', 'Adicionar Tributação')

@section('content')

<div class="col-md-8 mx-auto align-items-center">
    <div class="card">
        <div class="card-header">
            <h4>Alterar tributação</h4>
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

        <form action="{{ route('tributacao.update', ['tributacao' => $tributacao['id'] ])}}" method="POST">
            @method('put')
            @csrf
                <div class="row">

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label">Cliente*</label>
                            <input type="text" value="{{$tributacao['cliente']['nome']}}" class="form-control" required disabled>
                        </div>
                    </div><!-- Col -->

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label">Data*</label>
                            <input name="data" value="{{$tributacao['data']}}" type="date" class="form-control" required>
                        </div>
                    </div><!-- Col -->

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label">Tributação*</label>
                            <select name="tipo" class="form-control" required>
                                <option selected="" disabled="">Selecione...</option>
                                <option value="Presumido" @selected($tributacao['tipo'] === 'Presumido')>Presumido</option>
                                <option value="Simples Nacional" @selected($tributacao['tipo'] === 'Simples Nacional')>Simples Nacional</option>
                                <option value="Real Trimestral" @selected($tributacao['tipo'] === 'Real Trimestral')>Real Trimestral</option>
                                <option value="Real Anual" @selected($tributacao['tipo'] === 'Real Anual')>Real Anual</option>
                                <option value="Isenta" @selected($tributacao['tipo'] === 'Isenta')>Isenta</option>
                                <option value="Imune" @selected($tributacao['tipo'] === 'Imune')>Imune</option>
                            </select>
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
