@extends('layouts.main')

@section('page-title','Novo Cliente')

@section('page-links')
<li class="breadcrumb-item">
    <a href="{{route('customers.index')}}">Clientes</a>
</li>
<li class="breadcrumb-item active">
    <strong>Novo Cliente</strong>
</li>
@endsection

@section('page-content')

<div class="row">

    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Novo Cliente</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-wrench"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#" class="dropdown-item">Config option 1</a>
                        </li>
                        <li><a href="#" class="dropdown-item">Config option 2</a>
                        </li>
                    </ul>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">
                <form action="{{route('customers.store')}}" method="post">
                    @csrf
                    <div class="form-group row @error('cnpj') has-error @enderror">
                        <label class="col-lg-2 text-right col-form-label">CNPJ</label>
                        <div class="col-lg-10">
                            <input type="text" placeholder="Apenas números" class="form-control" name="cnpj" value="{{ old('cnpj') ?? '' }}" max="14">
                            @error('cnpj')
                            <span class="form-text m-b-none">{{$errors->first('cnpj')}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row @error('razao_social') has-error @enderror">
                        <label class="col-lg-2 text-right col-form-label">Razão Social</label>
                        <div class="col-lg-10">
                            <input type="text" placeholder="" class="form-control" name="razao_social" value="{{ old('razao_social') ?? '' }}">
                            @error('razao_social')
                            <span class="form-text m-b-none">{{$errors->first('razao_social')}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row @error('nome_fantasia') has-error @enderror">
                        <label class="col-lg-2 text-right col-form-label">Nome Fantasia</label>
                        <div class="col-lg-10">
                            <input type="text" placeholder="" class="form-control" name="nome_fantasia" value="{{ old('nome_fantasia') ?? '' }}">
                            @error('nome_fantasia')
                            <span class="form-text m-b-none">{{$errors->first('nome_fantasia')}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-lg-2 text-right col-form-label"></label>
                        <div class="col-lg-10">
                            <div class="i-checks">
                                <label class="">
                                    <div class="icheckbox_square-green" style="position: relative;">
                                        <input type="checkbox" style="position: absolute; opacity: 0;" name="geiko_on">
                                        <ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                    </div> Enviar Geiko
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-lg-2 text-right col-form-label"></label>
                        <div class="col-lg-10">
                            <div class="i-checks">
                                <label class="">
                                    <div class="icheckbox_square-green" style="position: relative;">
                                        <input type="checkbox" style="position: absolute; opacity: 0;" name="bomcontrolle_on">
                                        <ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                    </div> Enviar BomControlle
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-lg-2 text-right col-form-label"></label>
                        <div class="col-lg-offset-2 col-lg-10">
                            <button class="btn btn-sm btn-primary" type="submit">Cadastrar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('css')
<link href="{{ asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">
<link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
@endsection
@section('scripts')
<script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
    });
</script>
@endsection