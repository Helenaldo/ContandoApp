@extends('layouts.layout_principal')
@section('title', 'Alterar Usuário')

@section('content')

<div class="col-md-8 mx-auto align-items-center">
    <div class="card">
        <div class="card-header">
            <h4>Alterar Usuário</h4>
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

        <form action="{{ route('user.update', ['user' => $user['id'] ])}}" method="POST" enctype="multipart/form-data">
            @method('put')
            @csrf

                <div class="row">

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label">Nome*</label>
                            <input name="name" value="{{ $user['name'] }}" type="text" class="form-control" required>
                        </div>
                    </div><!-- Col -->

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label">E-mail*</label>
                            <input name="email" value="{{ $user['email'] }}" type="email" class="form-control" required>
                        </div>
                    </div><!-- Col -->

                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label">Status*</label>
                            <select name="status" class="form-control" required>
                                <option selected="" disabled="">Selecione...</option>
                                <option value="Administrador" @selected($user['status'] === 'Administrador') >Administrador</option>
                                <option value="Operador" @selected($user['status'] === 'Operador')>Operador</option>
                            </select>
                        </div>
                    </div><!-- Col -->
                </div><!-- Row -->

                <div class="row">

                    <div class="form-group col-sm-4">
                        <label>Avatar</label>
                        <input type="file" name="avatar" class="file-upload-default">
                        <div class="input-group">
                            <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload da Imagem">
                            <span class="input-group-append">
                                <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                            </span>
                        </div>
                    </div>

                    <div class="form-group col-sm-3">
                        <label class="control-label">Ativo</label>
                        <select name="ativo" class="form-control" required>
                            <option selected="" disabled="">Selecione...</option>
                            <option value="1" @selected($user['ativo'] === 1) >Ativo</option>
                            <option value="0" @selected($user['ativo'] === 0)>Inativo</option>
                        </select>
                    </div>

                </div><!-- Row -->

                <button type="submit" class="btn btn-primary d-inline-flex align-items-center mr-2">Salvar<i class="mdi mdi-cloud-upload ml-2"></i></button>
                <a href="{{route('user.index')}}" class="btn btn-light d-inline-flex align-items-center mr-2">Cancelar<i class="mdi mdi-close-circle-outline ml-2"></i></a>
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
