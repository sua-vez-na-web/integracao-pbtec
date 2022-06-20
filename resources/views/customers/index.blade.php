@extends('layouts.main')

@section('page-title','Clientes')

@section('page-links')
<li class="breadcrumb-item">
    <a href="{{ route('customers.index') }}">Clientes</a>
</li>
<li class="breadcrumb-item active">
    <strong>Lista de Clientes</strong>
</li>
@endsection

@section('page-actions')
<a href="{{ route('customers.create') }}" class="btn btn-primary">Adicionar Cliente</a>
@endsection

@section('page-content')

<div class="row">

    <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Clientes</h5>
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
                <div class="row">
                    <div class="col-sm-3">
                        <form action="" method="get">
                            <div class="d-flex flex-row">
                                <div class="input-group">
                                    <input placeholder="Pequisar por CNPJ" type="text" class="form-control form-control-sm" name="cnpj">
                                    <span class="input-group-append">
                                        <button type="submit" class="btn btn-sm btn-primary">Pesquisar</button>
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#cnpj</th>
                            <th>Razão Social</th>
                            <th>Nome Fantasia</th>
                            <th>Código BC</th>
                            <th>Código Geiko</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customers as $customer)
                        <tr>
                            <td>{{$customer->cnpj ?? ''}}</td>
                            <td>{{$customer->razao_social ?? ''}}</td>
                            <td>{{$customer->nome_fantasia ?? ''}}</td>
                            <td>{{$customer->bomcontrole_id ?? ''}}</td>
                            <td>{{$customer->geiko_id ?? ''}}</td>
                            <td>{{$customer->status ?? ''}}</td>
                            <th>
                                <a href="{{ route('customers.edit',$customer->id) }}" class="btn btn-primary"><i class="fa fa-eye"></i></a>
                            </th>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection