@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center text-center" style='height: 600px'>
  <div class="d-flex flex-column justify-content-center">

    <h1>Errore 404</h1>
    <p>La pagina richiesta non è stata trovata.</p>
    <a class="btn btn-outline-primary" href="{{ route('admin.houses.index') }}">Torna alla homepage</a>
  </div>

</div>
@endsection