@extends('layout')

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class="card uper">
  <div class="card-header">
    Edit time Data
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
      <form method="post" action="{{ route('times.update', $time->id ) }}">
          <div class="form-group">
              @csrf
              @method('PATCH')
              <label for="country_name">Time Nome:</label>
              <input type="text" class="form-control" name="nome" value="{{ $time->nome }}"/>
          </div>
          <div class="form-group">
              <label for="cases">Time Logo:</label>
              <input type="text" class="form-control" name="logo" value="{{ $time->logo }}"/>
          </div>
          <br>
          <button type="submit" class="btn btn-primary">Atualizar Data</button>
      </form>
  </div>
</div>
@endsection