@extends('layouts.app')

@section('content')

<div class="container">
    <h2 class="fs-4 text-secondary my-4">
        {{ __('Dashboard') }}
    </h2>
    @if ($houses->isEmpty())
    <div class="mb-4">
        <div>
            <p>Nessuna casa nella lista</p>
        </div>
        <div>
            <a class="btn btn-outline-success" href="{{ route('admin.houses.create') }}">Aggiungi una nuova casa</a>
        </div>
    </div>
    
        
    @else
        <div class="row justify-content-center g-2">
            <div class="d-flex justify-content-between mb-4">
                <a class="btn btn-outline-success" href="{{ route('admin.houses.create') }}">Aggiungi una nuova casa</a>
                <a class="btn btn-outline-danger" href="{{ route('admin.houses.trash.index') }}">Vedi cestino</a>
            </div>
            
            {{-- Table Houses --}}
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-header">My Houses</div>
                    <div class="card-body overflow-auto">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th class="d-none d-lg-table-cell" scope="col">Message</th>
                                <th class="d-none d-lg-table-cell" scope="col">Sponsorship</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($houses as $key => $house)
                                {{-- @dump($house) --}}
                                    <tr class="row-house" >
                                        {{-- @dump($key) --}}
                                        <th scope="row">{{ $houses->firstItem() + $loop->index }}</th>
                                        <td id="house-title">{{$house->title}}</td>
                                        <td class="d-none d-lg-table-cell">{!!$house->getMessagge()!!}</td>
                                        <td class="d-none d-lg-table-cell">{!!$house->getSponsorship()!!}</td>
                                        <td>
                                            <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap ">
                                            <a class="btn btn-outline-primary" href="{{ route('admin.houses.edit', $house) }}">Modifica</a>
                                            <a class="btn btn-outline-primary" href="{{ route('admin.houses.show', $house) }}">Info</a>
                                            @include('admin.houses.partials.delete_button')
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-5 d-flex justify-content-center">
                            {{ $houses->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tables Messages and Sponsorship --}}
            <div class="col-12 col-lg-4">
                <div class="row g-4">
                    
                    {{-- Messages --}}
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">Messages</div>
                            
                            <div class="card-body overflow-auto">
                                @if (!$messages)
                                    <p>Nessun messaggio</p>
                                @else
                                    
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Text</th>
                                            <th scope="col">House</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($messages as $message)     
                                        {{-- @dump($message)                                    --}}
                                            <tr>
                                                <th scope="row">{{ $loop->index+1}}</th>
                                                <td><a class="text-decoration-none text-dark" href="{{ route('admin.houses.show', $message->house_id)}}">{{strlen($message->text) > 10 ? substr($message->text, 0, 10) . "..." : $message->text}}</a></td>
                                                <td>{{$message->title}}</td>
                                            </tr>                                        
                                            @endforeach
                                    </tbody>
                                </table>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    {{-- Sponsorships --}}
                    <div class="col-12">                    
                        <div class="card">
                            <div class="card-header">Sponsorship</div>                            
                            <div class="card-body overflow-auto">
                                @if (!$houseSponsorshipList->toArray())
                                    <p>Nessuna casa sponsorizzata</p>
                                
                                @else
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">House</th>
                                            <th scope="col">Sponsorship</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($houseSponsorshipList as $house)
                                        <tr>
                                            <th scope="row">{{ $loop->index+1}}</th>
                                            <td><a class="text-decoration-none text-dark" href="{{ route('admin.houses.show', $house->id)}}">{{$house->title}}</a></td>
                                            @foreach ($house->sponsorships as $sponsorship)
                                            <td class="text-capitalize">{{$sponsorship->name}}</td>
                                            
                                            @endforeach
                                        </tr>
                                        
                                        @endforeach
                                    </tbody>
                                </table>
                                @endif
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
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

@section('scripts')
    <script>
        const elements = document.getElementsByClassName("row-house");
        // element.addEventListener("click", myFunction());

        let myFunction = function() {
        let attribute = this.getAttribute("data-myattribute");
        console.log(index);
        };

        for (let i = 0; i < elements.length; i++) {
            elements[i].addEventListener('click', myFunction, false);
        }

        // Array.prototype.forEach.call(elements, function (toggleExtra, index, element) {
        //     toggleExtra.addEventListener('click', function () {
        // console.log(index);
        // console.log(element);
        // })
        // });
    </script>
    
@endsection
