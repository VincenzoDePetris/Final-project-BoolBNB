@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <a class="btn btn-outline-success" href="{{ route('admin.houses.index') }}">Torna alla Lista</a>
        <h1 class="my-3">Il Tuo Cestino</h1>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3">
            @forelse ($houses as $house)
                <div class="col">
                    <div class="card h-100">
                        <img src="{{ asset('/storage/' . $house->cover_image) }}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h4 class="card-title">{{$house->title}}</h4>
                            <p class="card-text">{{$house->description}}</p>
                            <p class="card-text"><strong>Casa eliminata in data:</strong> {{$house->deleted_at}}</p>

                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div class="btn-group">
                                    <a href="#" data-bs-toggle="modal"
                                        data-bs-target="#restore-house-modal-{{ $house->id }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="fa-solid fa-arrow-turn-up fa-rotate-270 text-dark me-1"></i>
                                        Ripristina
                                    </a>
                                    {{-- <a href="#" data-bs-toggle="modal"
                                        data-bs-target="#delete-house-modal-{{ $house->id }}" class="btn btn-sm btn-outline-danger">
                                        <i class="fa-solid fa-plane-departure me-1"></i>
                                        Elimina
                                    </a> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <h1 >E' Vuoto</h1>
                </div>
            @endforelse
        </div>

        <div class="mt-5 d-flex justify-content-center">
            {{ $houses->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection


@section('modals')
    @foreach ($houses as $house)
        {{-- <div class="modal fade" id="delete-house-modal-{{ $house->id }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">{{ $house->title }}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Vuoi davvero eliminare definitivamente la casa '{{ $house->title }}'?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Chiudi</button>

                        <form method="POST" action="{{ route('admin.houses.trash.force-destroy', $house) }}">
                            @method('DELETE')
                            @csrf
                            <button class="btn btn-danger">Elimina</button>
                        </form>
                    </div>
                </div>
            </div>
        </div> --}}

        {{-- RESTORE --}}
        <div class="modal fade" id="restore-house-modal-{{ $house->id }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Conferma ripristino</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Vuoi davvero ripristinare la casa '{{ $house->title }}'?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Chiudi</button>

                        <form method="POST" action="{{ route('admin.houses.trash.restore', $house) }}">
                            @method('PATCH')
                            @csrf
                            <button class="btn btn-success">Ripristina</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection