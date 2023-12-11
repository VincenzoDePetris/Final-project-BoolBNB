@extends('layouts.app')

@section('content')
<div class="container">
  <h1 class="my-3">{{ $house->title }}</h1>
  <div class="row">
    <div class="col-md-6">
      <img
        src="{{ $house->cover_image == 'https://placehold.co/600x400' ? 'https://placehold.co/600x400' : asset('/storage/'. $house->cover_image) }}"
        alt="" class="img-fluid">
    </div>
    <div class="col-md-6">
      <h5>Galleria</h5>
      <div class="img-container row">
        @if($gallery_images)
        @foreach($gallery_images as $gallery_image)
        <div class="col-4 g-2">
          <img src="{{ asset('/storage/' . $gallery_image->image) }}" alt="" class="img-fluid">
        </div>
        @endforeach
        @endif
      </div>
    </div>
    <div class="col-md-6 my-4">
      <div>
        <p>
        <h3>Descrizione: <br></h3>
        @php
        $descriptionTagliata = str_split($house->description, 70);
        echo implode('<br>', $descriptionTagliata);
        @endphp
        </p>
      </div>
      <p><strong>Intestatario:</strong> {{ $user->name }} {{ $user->last_name }}</p>
      <p><strong>Indirizzo: </strong>{{ $house->address }}</p>
    </div>
    {{-- LISTA MESSAGGI --}}
    @if ($house->messages->toArray())
    <div class="col-md-5 col-sm-4 my-4 border p-4">
      <h4 class="mb-5">Lista messaggi ricevuti:</h4>
      @foreach ($house->messages as $message)
      <div class="mb-4">
        <p><strong>E-mail Mittente:</strong> {{$message->email}}</p>
        <p><strong>Testo messaggio:</strong> {!! wordwrap($message->text, 30 , "<br />\n", true) !!}</p>
      </div>
      <hr>
      @endforeach
    </div>
    @else
    <div class="col-md-6 my-4 border p-4 rounded">
      <h4>Nessun messaggio ricevuto</h4>
    </div>
    @endif

  </div>
  <div class="row">
    {{-- CARATTERISTICHE CASA --}}

    <div class="col-md-6">
      <h3>Caratteristiche</h3>
      <p><b>Stanze:</b> {{$house->rooms}}</p>
      <p><b>Metri quadri:</b> {{$house->sq_meters}}</p>
      <p><b>Numeri di letti:</b> {{$house->beds}}</p>
      <p><b>Numero di bagni:</b> {{$house->bathrooms}}</p>

      <h3>Servizi aggiuntivi</h3>
      <div class="col-md-6 d-flex gap-3 mb-5 mt-3">
        @foreach($house->extras as $extra)
        <div class="d-flex flex-column align-items-center">
          <div>{!! $extra->icon !!}</div>
          <div class=""><span class='badge' style='background-color: {{$extra->color}}'>{{$extra->name}}</span></div>
        </div>
        @endforeach
      </div>

    </div>
    <div class="col-md-6">
      <p>
        <strong>Promozione in Corso:</strong>
        @if ($house_sponsorship && $sponsorship)
          <div class="card">
            <div class="justify-content-around text-center">
              <h2 class="card-header mb-2 text-capitalize">{{$sponsorship->name}}</h2>
              {{-- <h2 class="card-text mb-2">€ {{$sponsorship->price}}</h2> --}}
              <p>La tua promozione scadrà il: 
                <b>{{$house_sponsorship->end_date}}</b>
              </p>
            </div>
          </div>
        @else
          <span>Non sponsorizzato</span>
          <div>
            <a href="{{ route('admin.houses.sponsorship', $house) }}" class="btn btn-dark">Sponsorizza il tuo
            appartamento</a>
          </div>
        @endif
      </p>
    </div>
  </div>
</div>
@endsection