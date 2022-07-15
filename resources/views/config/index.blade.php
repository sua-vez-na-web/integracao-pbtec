@extends('layouts.main')

@section('page-title','Configuração')

@section('page-links')
<li class="breadcrumb-item">
    <a href="#">Operações</a>
</li>
@endsection

@section('page-content')

<div class="row">


    <div class="col-12">
        <div class="ibox">
            <div class="ibox-header">

            </div>
            <div class="ibox-content">

                <form action="{{ route('config.run') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for=""></label>
                        <select name="command" id="command" class="form-control">
                            <option value="bills:update">bills:update | Consulta faturas no Bom Controlle</option>
                            <option value="bills:run">bills:run | Gera notificacções no GEIKO</option>
                            <option value="geiko:notification">geiko:notification | Atualiza faturas Pagas</option>
                            <option value="artisan:test">artisan:test | Teste de comando</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">Enviar</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>



@endsection