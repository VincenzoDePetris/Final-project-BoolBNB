@extends('layouts.app')

@section('content')
<div class="container">
    <div class="container mt-5">
        <h1>{{$house->title}}</h1>
        <div class="mb-5">

            <i class="fa-solid fa-location-dot text-danger me-2"></i><span>Address:</span>
            <span> {{ $house->address }}</span>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="image">
                    <img src="{{ $house->cover_image == 'https://placehold.co/600x400' ? 'https://placehold.co/600x400' : asset('/storage/'. $house->cover_image) }}" class="img-fluid" id="cover_image_preview">
                </div>
            </div>
            <div class="col-12">
                

                <h2>Sponsorizza la tua casa</h1>  
                <h5>Scegli la tua promozione</h5> 
                 
                {{-- <form action="{{ route('admin.sponsorship.payment', $house->id) }}" method="post">
                    @csrf
                    <select name="sponsorship_id" id="sponsorship_id" class="form-select">
                        @foreach ($sponsorships as $sponsorship)
                            <option value="{{ $sponsorship->id }}" @if (old('sponsorship_id') == $sponsorship->id) selected @endif>
                                {{ $sponsorship->label }} - €{{$sponsorship->price}} - {{$sponsorship->duration}} ore
                            </option>
                        @endforeach
                    </select>
                    <button class="btn btn-success my-5" id="form-button">Invia</button>
                    
                </form> --}}

                <div class="card-deck d-flex gap-3 justify-content-around text-center">
                    @foreach ($sponsorships as $sponsorship)
                    <form action="{{route('admin.sponsorship.payment', $house->id)}}" 
                        method="POST" enctype="multipart/form-data" 
                        class="card col-lg-4 mt-4 mb-5 border border-primary text-primary pt-3 pb-3">
                      @csrf
                    
                        <h2 class="card-title">{{$sponsorship->name}}</h2>
                        <h2 class="card-title">€ {{$sponsorship->price}}</h2>
                        <hr>
                        <h5 class="card-title">Sponsorizza il tuo appartamento per {{$sponsorship->duration}} ore!</h5>
                        <input type="hidden" name="house_id" value="{{$house->id}}">
                        <input type="hidden" name="price" value="{{$sponsorship->price}}">
                        <input type="hidden" name="sponsorship_id" value="{{$sponsorship->id}}">
                        <input type="submit" class="btn btn-success" value="Acquista">
                    
                    </form>
                    @endforeach
                  </div>
                </div>

            </div>
            
        </div>
    </div>

@endsection