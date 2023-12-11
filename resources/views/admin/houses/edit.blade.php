@extends('layouts.app')

@section('content')
<section class="container">

  @include('admin.houses.partials.form', ["title" => "Edit House","essential" => "", "route" => 'admin.houses.update', 'idForm'=>'create-form', 'methodRoute' => 'PATCH', 'btnClass' => 'create-btn'])

@endsection
@section('modals')
    @foreach ($house as $houses)
        <div class="modal fade" id="delete-house-modal-{{ $house->id }}" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">{{ $house->title }}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Vuoi davvero mettere nel cestino la casa {{ $house->title }}?
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
    const previewImg = document.getElementById('cover_image_preview');
    const inputFile = document.getElementById('cover_image');

    if (!previewImg.getAttribute('src') || previewImg.getAttribute('src') == "http://localhost:8000/storage" ){
        previewImg.src = "https://picsum.photos/200"
    }

    inputFile.addEventListener('change', function() {
        const [file] = this.files
        previewImg.src= URL.createObjectURL(file);
    })

</script>
@endsection