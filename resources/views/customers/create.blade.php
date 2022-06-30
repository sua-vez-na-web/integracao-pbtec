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
                        <div class="col-lg-4">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Apenas números" id="cnpj" class="form-control" name="cnpj" value="{{ old('cnpj') ?? '' }}" max="14">

                                <span class="input-group-append">
                                    <button type="button" class="btn btn-primary" id="btnConsultar">Consullar Cadastro
                                    </button>
                                </span>
                            </div>
                            <span class="text-block text-danger" id="message"></span>
                            @error('cnpj')
                            <span class="form-text m-b-none">{{$errors->first('cnpj')}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row @error('razao_social') has-error @enderror">
                        <label class="col-lg-2 text-right col-form-label">Razão Social</label>
                        <div class="col-lg-10">
                            <input type="text" placeholder="" id="razao_social" class="form-control" name="razao_social" value="{{ old('razao_social') ?? '' }}">
                            @error('razao_social')
                            <span class="form-text m-b-none">{{$errors->first('razao_social')}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row @error('nome_fantasia') has-error @enderror">
                        <label class="col-lg-2 text-right col-form-label">Nome Fantasia</label>
                        <div class="col-lg-10">
                            <input type="text" placeholder="" id="nome_fantasia" class="form-control" name="nome_fantasia" value="{{ old('nome_fantasia') ?? '' }}">
                            @error('nome_fantasia')
                            <span class="form-text m-b-none">{{$errors->first('nome_fantasia')}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row @error('tipo_cadastro') has-error @enderror">
                        <label class="col-lg-2 text-right col-form-label">Tipo Cadastro</label>
                        <div class="col-lg-10">
                            <input type="text" placeholder="" id="tipo_cadastro" class="form-control" name="tipo_cadastro" value="{{ old('tipo_cadastro') ?? '' }}">
                            @error('tipo_cadastro')
                            <span class="form-text m-b-none">{{$errors->first('tipo_cadastro')}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row @error('contato') has-error @enderror">
                        <label class="col-lg-2 text-right col-form-label">Contato</label>
                        <div class="col-lg-10">
                            <input type="text" placeholder="" id="contato" class="form-control" name="contato" value="{{ old('contato') ?? '' }}">
                            @error('contato')
                            <span class="form-text m-b-none">{{$errors->first('contato')}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row @error('telefone') has-error @enderror">
                        <label class="col-lg-2 text-right col-form-label">Telefone</label>
                        <div class="col-lg-10">
                            <input type="text" placeholder="" id="telefone" class="form-control" name="telefone" value="{{ old('telefone') ?? '' }}">
                            @error('telefone')
                            <span class="form-text m-b-none">{{$errors->first('telefone')}}</span>
                            @enderror
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row @error('cep') has-error @enderror">
                        <label class="col-lg-2 text-right col-form-label">CEP</label>
                        <div class="col-lg-10">
                            <input type="text" placeholder="" id="cep" class="form-control" name="cep" value="{{ old('cep') ?? '' }}">
                            @error('cep')
                            <span class="form-text m-b-none">{{$errors->first('cep')}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row @error('logradouro') has-error @enderror">
                        <label class="col-lg-2 text-right col-form-label">Logradouro</label>
                        <div class="col-lg-10">
                            <input type="text" placeholder="" id="logradouro" class="form-control" name="logradouro" value="{{ old('logradouro') ?? '' }}">
                            @error('logradouro')
                            <span class="form-text m-b-none">{{$errors->first('logradouro')}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row @error('numero') has-error @enderror">
                        <label class="col-lg-2 text-right col-form-label">Número</label>
                        <div class="col-lg-10">
                            <input type="text" placeholder="" id="numero" class="form-control" name="numero" value="{{ old('numero') ?? '' }}">
                            @error('numero')
                            <span class="form-text m-b-none">{{$errors->first('numero')}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row @error('bairro') has-error @enderror">
                        <label class="col-lg-2 text-right col-form-label">Bairro</label>
                        <div class="col-lg-10">
                            <input type="text" placeholder="" id="bairro" class="form-control" name="bairro" value="{{ old('bairro') ?? '' }}">
                            @error('bairro')
                            <span class="form-text m-b-none">{{$errors->first('bairro')}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row @error('cidade') has-error @enderror">
                        <label class="col-lg-2 text-right col-form-label">Cidade</label>
                        <div class="col-lg-10">
                            <input type="text" placeholder="" id="cidade" class="form-control" name="cidade" value="{{ old('cidade') ?? '' }}">
                            @error('cidade')
                            <span class="form-text m-b-none">{{$errors->first('cidade')}}</span>
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

        $('#btnConsultar').on('click', async function() {

            const cnpj = $('#cnpj').val();

            $.ajax({
                url: '/consultaClienteBycnpj?cnpj=' + cnpj,
                type: 'GET',
                success: function(res) {
                    console.log(res);
                    preencherCampos(res.data)

                    $('#message').html(res.message);

                },
                error: function(error) {
                    console.log(err)
                }
            });

        });

        function preencherCampos(campos) {
            $('#nome_fantasia').val(campos.fantasia ?? campos.nome_fantasia);
            $('#razao_social').val(campos.razao_social);
            $('#tipo_cadastro').val(campos.tipo_pessoa ?? campos.tipo_cadastro);
            $('#contato').val(campos.contato);
            $('#telefone').val(campos.telefone);
            $('#cep').val(campos.endereco ? campos.endereco.cep : campos.cep);
            $('#logradouro').val(campos.endereco ? campos.endereco.logradouro : campos.logradouro);
            $('#bairro').val(campos.endereco ? campos.endereco.bairro : campos.bairro);
            $('#cidade').val(campos.endereco ? campos.endereco.cidade : campos.cidade);
            $('#numero').val(campos.endereco ? campos.endereco.numero : campos.numero)
        }
    });
</script>
@endsection