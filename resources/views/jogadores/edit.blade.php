@extends('layout')

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="card uper">
  <div class="card-header">
    Edit jogador Data
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
      <form method="post" action="{{ route('jogadores.update', $jogador->id ) }}">
          <div class="form-group">
              @csrf
              @method('PATCH')
              <label for="country_name">jogador Nome:</label>
              <input type="text" class="form-control" name="nome" value="{{ $jogador->nome }}"/>
          </div>
          <div class="form-group">
              <label for="cases">jogador E-mail :</label>
              <input type="text" class="form-control" name="email" value="{{ $jogador->email }}"/>
          </div>
          <div class="form-group">
              <label for="cases">jogador Nickname :</label>
              <input type="text" class="form-control" name="nickname" value="{{ $jogador->nickname }}"/>
          </div>
          <br>
          <button type="submit" class="btn btn-primary">Atualizar Data</button>
      </form>
  </div>
</div>
@endsection