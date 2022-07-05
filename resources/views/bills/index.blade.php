@extends('layouts.main')

@section('page-title','Faturas')

@section('page-links')
<li class="breadcrumb-item">
    <a href="{{ route('bills.index') }}">Faturas</a>
</li>
<li class="breadcrumb-item active">
    <strong>Lista de Faturas</strong>
</li>
@endsection

@section('page-content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h5>Faturas</h5>
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
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#ID</th>
                            <th>Fatura</th>
                            <th>Cliente</th>
                            <th>CNPJ</th>
                            <th>Dt. Vencimento</th>
                            <th>Valor</th>
                            <th>Dt. Cadastro.</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($bills as $bill)
                        <tr>
                            <td>{{$bill->id}}</td>
                            <td>{{$bill->bill_id}}</td>
                            <td>
                                {{$bill->customer->razao_social ?? $bill->customer->nome_fantasia ?? '---'}}
                            </td>
                            <td>{{$bill->customer->cnpj ?? ''}}</td>
                            <td>{{$bill->due_date->format('d/m/Y')}}</td>
                            <td>${{number_format($bill->due_amount,2,',','.')}}</td>
                            <td>{{$bill->created_at->format('d/m/Y')}}</td>
                            <td>
                                <a href="{{ route('bills.show',$bill->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a>
                            </td>
                        </tr>
                        @empty

                        <tr>
                            <td colspan="8">Nenhum Registro</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>


@endsection