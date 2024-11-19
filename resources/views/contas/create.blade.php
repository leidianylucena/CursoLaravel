@extends('layouts.admin')

    @section('content')
        <div class="card mt-4 mb-4 border-light shadow">
            <div class="card-header d-flex justify-content-between">
                <span>Cadastrar Conta</span>
                <span>
                    <a href="{{ route('conta.index') }}" class="btn btn-info btn-sm">Listar</a>
                </span>
            </div>

            @if (@session('success'))
                <div class="alert alert-success m-3" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger m-3" role="alert">
                    @foreach ($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif

            <div class="card-body">

                <form action="{{ route('conta.store') }}" method="POST" class="row g-3">
                    @csrf


                    <div class="col-12">
                        <label for="nome" class="form-label">Nome</label>
                        <input type="text" name="nome" class="form-control" id="nome" placeholder="Nome da conta" value="{{ old('nome') }}">
                    </div>

                    <div class="col-12">
                        <label for="valor" class="form-label">Valor</label>
                        <input type="text" name="valor" class="form-control" id="valor" placeholder="Valor da conta" value="{{ old('valor') }}">
                    </div>

                    <div class="col-12">
                        <label for="vencimento" class="form-label">Vencimento</label>
                        <input type="date" name="vencimento" class="form-control" id="vencimento" value="{{ old('vencimento') }}">
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-success bt-sm">Cadastrar</button>
                    </div>

                </form>

            </div>
        </div>
@endsection


