<form action="{{ route($route, $house->id) }}" id="{{$idForm}}" method="POST" class="my-2"
    enctype="multipart/form-data">
    @method($methodRoute)
    @csrf
    <div class="card">
        <div class="card-header">
            <h2 class="text-center mb-2">{{$title}}</h2>
        </div>
        <div class="card-body">

            {{-- Title --}}
            <div class="mb-3 w-50">
                <label for="title" class="form-label">Titolo {{$essential}}</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" maxlength="200" id="title"
                    name="title" value="{{ old('title',$house->title) }}">
                @error('title')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror

            </div>

            <div class="form-outline mb-3">
                <div id="address-element" class="form-control">
                    <label for="address" class="form-label">Indirizzo {{$essential}}</label>
                    <div id="address-element"></div>
                    @error('address')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            {{-- Cover Image --}}
            <div class="form-outline w-25 mb-3">
                <label for="cover_image" class="form-label">Foto della casa {{$essential}}</label>
                <input type="file" class="form-control @error('cover_image') is-invalid @enderror" id="cover_image"
                    name="cover_image" value="{{old('cover_image', $house->cover_image)}}">
                @error('cover_image')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            {{-- Preview Cover Image --}}
            <div class=" w-50">
                <img @if($methodRoute=='PATCH' ) src="{{asset('/storage/'. $house->cover_image)}}
            " @elseif ($methodRoute=='POST' ) src="" @endif class="img-fluid" id="cover_image_preview">
            </div>

            {{-- Gallery --}}
            <div class="form-outline mb-3">
                <label for="image" class="form-label">Foto di galleria</label>
                <input type="file" multiple class="form-control @error('image') is-invalid @enderror" id="image"
                    name="image[]" onchange="previewGallery(event)">
                @error('image')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            {{-- Image Preview Container --}}
            <div class="container">
                <div id="imagePreviewContainer" class="d-flex flex-wrap gap-2"></div>
            </div>


            {{-- Description --}}
            <div class="form-outline my-3">
                <label for="description" class="form-label">Descrizione {{$essential}}</label>
                <textarea type="text" class="form-control @error('description') is-invalid @enderror" id="description"
                    name="description" value="" cols="30"
                    rows="5">{{ old('description',$house->description) }}</textarea>
                @error('description')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            {{-- List rooms-bathromms- ecc... --}}
            <div class="row row-cols-md-4 row-cols-2">
                {{-- Rooms --}}
                <div class="col">
                    <div class="mb-3">
                        <label for="rooms" class="form-label">Stanze {{$essential}}</label>
                        <input type="number" min="1" class="form-control @error('rooms') is-invalid @enderror"
                            id="rooms" name="rooms" value="{{  old('rooms', $house->rooms) }}">
                        @error('rooms')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>
                </div>

                {{-- M2 --}}
                <div class="col">
                    <div class="mb-3">
                        <label for="sq_meters" class="form-label">Metri quadri {{$essential}}</label>
                        <input type="number" min="10" step="5"
                            class="form-control @error('sq_meters') is-invalid @enderror" id="sq_meters"
                            name="sq_meters" value="{{ old('sq_meters', $house->sq_meters) }}">
                        @error('sq_meters')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror

                    </div>
                </div>

                {{-- Beds --}}
                <div class="col">
                    <div class="mb-3">
                        <label for="beds" class="form-label">Letti {{$essential}}</label>
                        <input type="number" min="1" class="form-control @error('beds') is-invalid @enderror" id="beds"
                            name="beds" value="{{  old('beds', $house->beds) }}">
                        @error('beds')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                {{-- Bathrooms --}}
                <div class="col-4">
                    <div class="mb-3">
                        <label for="bathrooms" class="form-label">Bagni {{$essential}}</label>
                        <input type="number" min="1" class="form-control @error('bathrooms') is-invalid @enderror"
                            id="bathrooms" name="bathrooms" value="{{  old('bathrooms', $house->bathrooms) }}">
                        @error('bathrooms')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

            </div>

            {{-- List extras service --}}
            <div>
                <label for="extras" class="form-label">Servizi aggiuntivi {{$essential}}</label>
                <div class="form-check @error('extras') is-invalid @enderror">
                    <div class="row row-cols-md-4 row-cols-2 mt-3">
                        @foreach ($extras as $extra)
                        <div class="col">
                            <input type="checkbox" class="form-check-input" name="extras[]" id="extra-{{$extra->id}}"
                                value="{{$extra->id}}" @if(in_array($extra->id,
                            old('extras', $extra_house))) checked
                            @endif
                            >
                            <label class="form-check-label" for="extra-{{$extra->id}}">{{$extra->name}}</label>
                        </div>
                        @endforeach
                    </div>
                </div>
                @error('extras')
                <div class="invalid-feedback">
                    {{$message}}
                </div>
                @enderror
            </div>
        </div>

        <div class="card-footer">
            {{-- BTNS send form and cancel --}}
            <div class="text-end my-2 d-flex justify-content-end gap-2">
                <a href="{{ route('admin.houses.index')}}" class="btn btn-dark"><i
                        class="fa-solid fa-arrow-left"></i>&nbsp;Indietro</a>
                <button type="submit" class="btn btn-success {{$btnClass}}"><i
                        class="fa-solid fa-save"></i>&nbsp;Salva</button>
                @if($methodRoute == 'PATCH')
                @include('admin.houses.partials.delete_button')
                @endif
            </div>
            {{-- Required input --}}
            <div>
                <p class="fs-6 fst-italic text-secondary ms-3">Sono contrassegnati con * i dati obbligatori.
                </p>
            </div>
        </div>

        @include('admin.houses.partials.searchbar')
</form>

@section('scripts')
<script>
    // PROFILE PIC PREVIEW
const previewImg = document.getElementById('cover_image_preview');
const inputFile = document.getElementById('cover_image');

inputFile.addEventListener('change', function() {
const [file] = this.files
previewImg.src = URL.createObjectURL(file);
});


// // GALLERY PICS PREVIEW
function previewGallery(event) {
  const previewContainer = document.getElementById('imagePreviewContainer');
        
  const files = event.target.files;
    for (const file of files) {
      const reader = new FileReader();
        reader.onload = function (e) {
        const imgContainer = document.createElement('div');
        imgContainer.className = 'image-container';

        const img = document.createElement('img');
        img.src = e.target.result;

       imgContainer.appendChild(img);
      previewContainer.appendChild(imgContainer);
    };
    reader.readAsDataURL(file);
        }
    }
</script>

@endsection