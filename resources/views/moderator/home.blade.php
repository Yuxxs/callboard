@extends('layouts.app')

@section('content')
<div class="row equal">
    <div class="col-sm-8 d-flex pb-3 flex-wrap">
        @foreach($ads as $ad)
        <div class="col-sm-4 d-flex pb-3">
            <div class="card mb-4 shadow-sm">

                @if(count(Storage::disk('public')->files('uploads/'.$ad->user->id.'/'.$ad->id))>0)
                <img class="bd-placeholder-img card-img-top" width="100%" height="225"
                    src="{{asset('storage/'.Storage::disk('public')->files('uploads/'.$ad->user->id.'/'.$ad->id)[0])}}" />
                @else
                <svg class="bd-placeholder-img card-img-top" width="100%" height="225"
                    xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false"
                    role="img">

                    <rect width="100%" height="100%" fill="#55595c"></rect><text x="50%" y="50%" fill="#eceeef"
                        dy=".3em">
                </svg>
                @endif
                <h3 style="position: absolute;"><span class="badge badge-secondary">{{$ad->category->name}}</span></h3>
                <div class="card-body">
                    <div class="row">

                        <div class="col">
                            <h2 class="card-title">{{$ad->name}}</h2>
                        </div>
                        <div class="col">
                            <a href="{{route('ad.moderation',['id'=>$ad->id])}}" class="btn btn-primary"
                                type="button">Модерация</a>
                        </div>
                    </div>
                    <p class="card-text text-truncate" style="width: 17rem;">{{$ad->description}}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">Просмотров: {{$ad->views_count}}</small>
                    </div>
                </div>
            </div>
        </div>
        @endforeach


    </div>
</div>
</div>

@endsection