@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">

            <div class="">
                <h5>Статус</h5>
            </div>
        </div>
        <div class="col-md-2">
            <div class="text-nowrap" style="width: 20rem;">
                <p>{{$ad->status->name}}</p>
            </div>
        </div>
    </div>
    <hr class="mt-2 mb-5">
    <div class="row">
        <div class="col-md-12">
            @if($ad->moderations->count()>0)
            <h5 class="mb-1">Причины отклонения к доработке</h5>
            <ul class="list-group">
                @foreach($ad->moderations as $moderation)
                <li class="list-group-item @if($ad->moderations()->latest()->first()->id==$moderation->id) active @endif">{{$moderation->reason}}</li>
                @endforeach
            </ul>

            @endif 
            @if(Auth::check())
            @if(Auth::user()->role()->first()->slug=='moderator'||  Auth::user()->role()->first()->slug='admin')
            <form method="POST" action="{{ route('moderator.create_moderation',['id'=>$ad->id]) }}">
                @csrf
                <div class="form-group row">
                    <label for="reason" class="col-md-4 col-form-label text-md-right">{{ __('Причина') }}</label>

                    <div class="col-md-6">
                        <textarea class="form-control rounded-0 @error('reason') is-invalid @enderror" rows="2"
                            id="reason" name="reason" required autocomplete="reason"
                            autofocus> {{old('reason')}}</textarea>
                        @error('reason')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group row ">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" name='submit' class="btn btn-primary">
                            {{ __('Отправить на доработку') }}
                        </button>
                    </div>

                </div>
            </form>
            <div class="row">
                <div class="col-md-6 offset-md-4">
                    <form action="{{route('moderator.publish_ad',['id'=>$ad->id])}}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Опубликовать</button>
                    </form>
                </div>
            </div>
            @endif
            @endif
        </div>
       
    </div>

</div>
@endsection