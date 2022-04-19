<!-- create.blade.php -->

@extends('layout')

@section('content')
<style>
    .uper {
        margin-top: 40px;
    }
</style>
<div class="card uper">
    <div class="card-header">
        Add Jogadores Data
    </div>
    <div class="card-body">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div><br />
        @endif
        <br>
        <form method="post" action="{{ route('jogadores.store') }}">
            <div class="form-group">
                @csrf
                <label for="country_name">Nome:</label>
                <input type="text" class="form-control" name="nome" placeholder="Nome" />
            </div>
            <br>
            <div class="form-group">
                <label for="cases">E-mail :</label>
                <input type="text" class="form-control" name="email" placeholder="E-mail" />
            </div>
            <br>
            <div class="form-group">
                <label for="cases">Nickname :</label>
                <input type="text" class="form-control" name="nickname" placeholder="Nickname" />
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Adicionar Jogador</button>
        </form>
    </div>
</div>
@endsection