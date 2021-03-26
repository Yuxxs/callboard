@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">

                    <form method="post" action="{{ route('user.save_ad') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <input name="id" type="hidden" value="{{$ad->id??''}}">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="user-image mb-3 text-center">
                                    <div class="imgPreview"> </div>
                                </div>

                                <div class="custom-file">
                                    <input type="file" name="images[]" class="custom-file-input" id="images"
                                        multiple>
                                    <label class="custom-file-label" for="images">Choose image</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">

                                <div class="input-group mb-3">

                                    <span id="category" class="input-group-text" aria-describedby="category_button">

                                        {{$ad->category->name??'Без категории'}}
                                        <input name="category_id" type="hidden" value="{{ $ad->category->id??''}}">

                                    </span>
                                    <div class="input-group-prepend">

                                        <a id="category_button" class="btn btn-outline-secondary" type="button"
                                            role="button" aria-pressed="true"
                                            href="{{ route('user.choose_category', ['ad'=>$ad->toArray(),'category_id' => $ad->category->parent->id??'']) }}">Изменить</a>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="d-flex flex-row">
                                    <div class="p-2">
                                        <label for="countries_select">Страна</label>
                                        <br />

                                        <select class="form-select form-select-sm" id="countries_select"
                                            name="countries_select">

                                            @foreach ($countries as $country)
                                            <option value="{{ $country->id }}" @if($country->
                                                id==$ad->city->region->country->id) selected @endif>
                                                {{ $country->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="p-2">
                                        <label for="regions_select">Регион</label>
                                        <br />

                                        <select class="form-select form-select-sm" id="regions_select"
                                            name="regions_select">

                                            @foreach ($regions as $region)
                                            <option value="{{ $region->id }}" @if($region->id==$ad->city->region->id)
                                                selected @endif>
                                                {{ $region->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="p-2">
                                        <label for="cities_select">Город</label>
                                        <br />

                                        <select class="form-select form-select-sm" id="cities_select"
                                            name="cities_select">
                                            @foreach ($cities as $city)
                                            <option value="{{ $city->id }}" @if($city->id==$ad->city->id) selected
                                                @endif>
                                                {{ $city->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>




                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name"
                                class="col-md-4 col-form-label text-md-right">{{ __('Наименование') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ $ad->name }}" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="cost"
                                class="col-md-4 col-form-label text-md-right">{{ __('Стоимость') }}</label>

                            <div class="col-md-6">
                                <input id="cost" type="text" class="form-control @error('cost') is-invalid @enderror"
                                    name="cost" value="{{ $ad->cost }}" required autocomplete="cost" autofocus>

                                @error('cost')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="description"
                                class="col-md-4 col-form-label text-md-right">{{ __('Описание') }}</label>

                            <div class="col-md-6">
                                <textarea class="form-control rounded-0 @error('description') is-invalid @enderror"
                                    rows="2" id="description" name="description" required autocomplete="description"
                                    autofocus> {{$ad->description}}</textarea>
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" name='submit' class="btn btn-primary">
                                    {{ __('Сохранить') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script>
    $(function() {
            // Multiple images preview with JavaScript
            var multiImgPreview = function(input, imgPreviewPlaceholder) {

                if (input.files) {
                    var filesAmount = input.files.length;

                    for (i = 0; i < filesAmount; i++) {
                        var reader = new FileReader();

                        reader.onload = function(event) {
                            $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(
                                imgPreviewPlaceholder);
                        }

                        reader.readAsDataURL(input.files[i]);
                    }
                }

            };

            $('#images').on('change', function() {
                multiImgPreview(this, 'div.imgPreview');
            });
            $( document ).ready(function() {
                multiImgPreview(this, 'div.imgPreview');
            });
        });

</script>
<script>


</script>

@endsection
