@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between mb-4">
            <a class="btn btn-outline-success" href="{{ route('admin.houses.create') }}">Aggiungi una nuova casa</a>
            <a class="btn btn-outline-danger" href="{{ route('admin.houses.trash.index') }}">Vedi cestino</a>
        </div>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3">
            @foreach ($houses as $house)
                <div class="col">
                    <div class="card h-100">
                        <img src="{{ $house->cover_image == 'https://placehold.co/600x400' ? 'https://placehold.co/600x400' : asset('/storage/'. $house->cover_image) }}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h4 class="card-title">{{$house->title}}</h4>
                            <p class="card-text">{{$house->description}}</p>
                            <div class="d-flex  align-items-center gap-2  ">
                                <a class="btn btn-outline-primary " href="{{ route('admin.houses.edit', $house) }}">Modifica</a>
                                <a class="btn btn-outline-primary " href="{{ route('admin.houses.show', $house) }}">Info</a>
                                @include('admin.houses.partials.delete_button')
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-5 d-flex justify-content-center">
            {{ $houses->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection

@section('modals')
    @foreach ($houses as $house)
        <div class="modal fade" id="delete-house-modal-{{ $house->id }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">{{ $house->title }}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Vuoi davvero mettere nel cestino la casa '{{ $house->title }}'?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Chiudi</button>

                        <form method="POST" action="{{ route('admin.houses.destroy', $house) }}">
                            @method('DELETE')
                            @csrf
                            <button class="btn btn-danger">Elimina</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection