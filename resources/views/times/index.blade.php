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
          <td>Time Nome</td>
          <td>Time Logo</td>
          <td colspan="2">Action</td>
        </tr>
    </thead>
    <tbody>
        @foreach($times as $time)
        <tr>
            <td>{{$time->id}}</td>
            <td>{{$time->nome}}</td>
            <td>{{$time->logo}}</td>
            <td><a href="{{ route('times.edit', $time->id) }}" class="btn btn-primary">Editar</a></td>
        </tr>
        @endforeach
    </tbody>
  </table>
  <br>
  <a href="{{ route('times.create') }}">Adicionar Novo Time</a>
<div>
@endsection