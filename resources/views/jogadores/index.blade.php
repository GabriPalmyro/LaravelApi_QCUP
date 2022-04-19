<!-- index.blade.php -->

@extends('layout')

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="uper">
  @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}  
    </div><br />
  @endif
  <table class="table table-striped">
    <thead>
        <tr>
          <td>ID</td>
          <td>Jogador Nome</td>
          <td>Jogador E-mail</td>
          <td>Jogador Nickname</td>
          <td colspan="2">Action</td>
        </tr>
    </thead>
    <tbody>
        @foreach($jogadores as $jogador)
        <tr>
            <td>{{$jogador->id}}</td>
            <td>{{$jogador->nome}}</td>
            <td>{{$jogador->email}}</td>
            <td>{{$jogador->nickname}}</td>
            <td><a href="{{ route('jogadores.edit', $jogador->id) }}" class="btn btn-primary">Editar</a></td>
        </tr>
        @endforeach
    </tbody>
  </table>
  <br>
  <a href="{{ route('jogadores.create') }}">Adicionar novo Jogador</a>
<div>
@endsection