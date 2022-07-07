@extends('layouts.main')

@section('page-title','Detalhe Fatura')

@section('page-links')
<li class="breadcrumb-item">
    <a href="{{ route('bills.index') }}">Faturas</a>
</li>
<li class="breadcrumb-item active">
    <strong>Detalhe da Fatura</strong>
</li>
@endsection



@section('page-content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                Detalhe da Fatura
            </div>
            <div class="ibox-content">
                <form action="{{route('bills.notifygeiko')}}" method="post">
                    @csrf
                    <div class="form-group row @error('id') has-error @enderror">
                        <label class="col-lg-2 text-right col-form-label">ID</label>
                        <div class="col-lg-4">
                            <div class="input-group">
                                <input readonly type="text" value="{{ $bill->id ?? '' }}" class="form-control" id="id" class="form-control" name="id" value="{{ old('id') ?? '' }}">
                            </div>
                            <span class="text-block text-danger" id="message"></span>
                            @error('id')
                            <span class="form-text m-b-none">{{$errors->first('id')}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row @error('customer_id') has-error @enderror">
                        <label class="col-lg-2 text-right col-form-label">Cliente ID</label>
                        <div class="col-lg-4">
                            <div class="input-group">
                                <input readonly type="text" value="{{ $bill->customer_id ?? '' }}" class="form-control" id="customer_id" class="form-control" name="customer_id" value="{{ old('customer_id') ?? '' }}">
                            </div>
                            <span class="text-block text-danger" id="message"></span>
                            @error('customer_id')
                            <span class="form-text m-b-none">{{$errors->first('cnpj')}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row @error('cnpj') has-error @enderror">
                        <label class="col-lg-2 text-right col-form-label">CNPJ</label>
                        <div class="col-lg-4">
                            <div class="input-group">
                                <input readonly type="text" value="{{ $bill->customer->cnpj ?? '' }}" class="form-control" id="cnpj" class="form-control" name="cnpj" value="{{ old('cnpj') ?? '' }}">
                            </div>
                            <span class="text-block text-danger" id="message"></span>
                            @error('cnpj')
                            <span class="form-text m-b-none">{{$errors->first('cnpj')}}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row @error('razao_social') has-error @enderror">
                        <label class="col-lg-2 text-right col-form-label">Razao Social</label>
                        <div class="col-lg-10">
                            <div class="input-group">
                                <input type="text" value="{{ $bill->customer->razao_social ?? '' }}" class="form-control" id="razao_social" class="form-control" name="razao_social" value="{{ old('razao_social') ?? '' }}">
                            </div>
                            <span class="text-block text-danger" id="message"></span>
                            @error('razao_social')
                            <span class="form-text m-b-none">{{$errors->first('razao_social')}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row @error('nome_fantasia') has-error @enderror">
                        <label class="col-lg-2 text-right col-form-label">Fantasia</label>
                        <div class="col-lg-10">
                            <div class="input-group">
                                <input type="text" value="{{ $bill->customer->nome_fantasia ?? '' }}" class="form-control" id="nome_fantasia" class="form-control" name="nome_fantasia" value="{{ old('nome_fantasia') ?? '' }}">
                            </div>
                            <span class="text-block text-danger" id="message"></span>
                            @error('nome_fantasia')
                            <span class="form-text m-b-none">{{$errors->first('nome_fantasia')}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row @error('bill_id') has-error @enderror">
                        <label class="col-lg-2 text-right col-form-label">Fatura ID</label>
                        <div class="col-lg-4">
                            <div class="input-group">
                                <input type="text" value="{{ $bill->bill_id ?? '' }}" class="form-control" id="bill_id" class="form-control" name="bill_id" value="{{ old('bill_id') ?? '' }}">
                            </div>
                            <span class="text-block text-danger" id="message"></span>
                            @error('bill_id')
                            <span class="form-text m-b-none">{{$errors->first('bill_id')}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row @error('due_date') has-error @enderror">
                        <label class="col-lg-2 text-right col-form-label">Vencimento</label>
                        <div class="col-lg-10">
                            <div class="input-group">
                                <input type="date" value="{{ $bill->due_date->format('Y-m-d') ?? ''}}" class="form-control" id="due_date" class="form-control" name="due_date" value="{{ old('due_date') ?? '' }}">
                            </div>
                            <span class="text-block text-danger" id="message"></span>
                            @error('due_date')
                            <span class="form-text m-b-none">{{$errors->first('due_date')}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row @error('due_amount') has-error @enderror">
                        <label class="col-lg-2 text-right col-form-label">Valor R$</label>
                        <div class="col-lg-10">
                            <div class="input-group">
                                <input type="text" value="{{ number_format($bill->due_amount,2,',','.') }}" class="form-control" id="due_amount" class="form-control" name="due_amount" value="{{ old('due_amount') ?? '' }}">
                            </div>
                            <span class="text-block text-danger" id="message"></span>
                            @error('due_amount')
                            <span class="form-text m-b-none">{{$errors->first('due_amount')}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row @error('message') has-error @enderror">
                        <label class="col-lg-2 text-right col-form-label">Mensagem Notificar</label>
                        <div class="col-lg-10">
                            <div class="input-group">
                                <input type="text" name="message" id="message" placeholder="ENTRAR EM CONTATO COM FINANCEIRO" value="{{$bill->notification->message ?? 'ENTRAR EM CONTATO COM FINANCEIRO'}}" class="form-control">
                            </div>
                            <span class="text-block text-danger" id="message"></span>
                            @error('message')
                            <span class="form-text m-b-none">{{$errors->first('message')}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row @error('include_at') has-error @enderror">
                        <label class="col-lg-2 text-right col-form-label">Data Inclusão</label>
                        <div class="col-lg-10">
                            <div class="input-group">
                                <input type="date" value="{{ now()->format('Y-m-d') ?? ''}}" class="form-control" id="include_at" class="form-control" name="include_at" value="{{ old('include_at') ?? '' }}">
                            </div>
                            <span class="text-block text-danger" id="include_at"></span>
                            @error('include_at')
                            <span class="form-text m-b-none">{{$errors->first('include_at')}}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row @error('removed_at') has-error @enderror">
                        <label class="col-lg-2 text-right col-form-label">Data Baixa</label>
                        <div class="col-lg-10">
                            <div class="input-group">
                                <input type="date" value="{{ now()->addYear(1)->format('Y-m-d') ?? ''}}" class="form-control" id="removed_at" class="form-control" name="removed_at" value="{{ old('removed_at') ?? '' }}">
                            </div>
                            <span class="text-block text-danger" id="removed_at"></span>
                            @error('removed_at')
                            <span class="form-text m-b-none">{{$errors->first('removed_at')}}</span>
                            @enderror
                        </div>
                    </div>
                    @if($bill->customer->geiko_id)
                    <input type="hidden" name="geiko_id" value="{{$bill->customer->geiko_id}}">
                    <div class="form-group row">
                        <label for="" class="col-lg-2 text-right col-form-label"></label>
                        <div class="col-lg-offset-2 col-lg-10">
                            <button class="btn btn-sm btn-primary" type="submit">Enviar Notificação</button>
                        </div>
                    </div>
                    @else
                    <div class="form-group row">
                        <label for="" class="col-lg-2 text-right col-form-label"></label>
                        <div class="col-lg-offset-2 col-lg-10">
                            <a href="{{ route('customers.edit',$bill->customer->id) }}" class="btn btn-danger btn-sm">Cliente sem Dados do GEIKO, consulte o cadastro</a>
                        </div>
                    </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
@endsection