@extends('layouts.layout_principal')
@section('title', 'Movimentar processo')

@section('content')

<div class="col-md-8 mx-auto align-items-center">
    <div class="card">
        <div class="card-header">
            <h4>Adicionar novo movimento</h4>
        </div>
        <div class="card-body">


            @if (!empty($errors) && is_array($errors))
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
            @elseif(!empty($errors))
            <div class="alert alert-danger">
                <ul>
                {!! implode('', $errors->all('<li>:message</li>')) !!}
                </ul>
            </div>
            @endif


            <form action="{{ route('movimento.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                {{-- {{dd($processo)}} --}}
                <input type="hidden" name="cliente_id" value="{{$processo['cliente_id']}}">
                <input type="hidden" name="processo_id" value="{{$processo['id']}}">

                <div class="row">

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label">Cliente</label>
                            <input value="{{$processo['cliente']['nome']}}" type="text" class="form-control" disabled>
                        </div>
                    </div><!-- Col -->

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label">Processo</label>
                            <input value="{{$processo['titulo']}}" type="text" class="form-control" disabled>
                        </div>
                    </div><!-- Col -->

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label">Número do Processo</label>
                            <input value="{{$processo['numero']}}" type="text" class="form-control" disabled>
                        </div>
                    </div><!-- Col -->

                </div><!-- Row -->

                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">Usuário*</label>
                            <select name="user_id" class="form-control" required>
                                <option selected="" disabled="">Selecione...</option>
                                @foreach ($users as $user)
                                <option value="{{$user['id']}}" @selected(session('authenticated')['user']['id'] === $user['id'])>{{$user['name']}}</option>
                                @endforeach

                            </select>
                        </div>
                    </div><!-- Col -->

                    <div class="form-group col-sm-4">
                        <label>Anexo (somente pdf)</label>
                        <input type="file" name="anexo" class="file-upload-default">
                        <div class="input-group">
                            <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload">
                            <span class="input-group-append">
                                <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                            </span>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">Data*</label>
                            <input name="data" type="date" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="form-control" required>
                        </div>
                    </div><!-- Col -->

                </div><!-- Row -->

                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Descrição do movimento*</label>
                            <textarea class="form-control" name="descricao" rows="5" required></textarea>
                        </div>
                    </div><!-- Col -->

                </div><!-- Row -->

                <button type="submit" class="btn btn-primary d-inline-flex align-items-center mr-2">Salvar<i class="mdi mdi-cloud-upload ml-2"></i></button>
                <a href="javascript:history.back()" class="btn btn-light d-inline-flex align-items-center mr-2">Cancelar<i class="mdi mdi-close-circle-outline ml-2"></i></a>
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
