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
        Add Times Data
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
        <form method="post" action="{{ route('times.store') }}">
            <div class="form-group">
                @csrf
                <label for="country_name">Nome:</label>
                <input type="text" class="form-control" name="nome" placeholder="Nome" />
            </div>
            <br>
            <div class="form-group">
                <label for="cases">E-mail :</label>
                <input type="text" class="form-control" name="logo" placeholder="Logo" />
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Adicionar Time</button>
        </form>
    </div>
</div>
@endsection