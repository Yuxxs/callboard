@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row equal">
            <div class="col-sm-8 d-flex pb-3 flex-wrap">

            </div>
        </div>
        <div class="row equal">
            <div class="col-sm-8 d-flex pb-3 flex-wrap">
                <div class="p-2 bd-highlight">
                    <h2 class="font-weight-light text-center text-lg-left mt-4 mb-0">
                        @if($current_category??false)
                            {{$current_category->name}}
                        @else
                            Все категории
                        @endif
                    </h2>
                </div>
            </div>
        </div>

        <hr class="mt-2 mb-5">

        <div class="row equal">
            <div class="d-flex pb-3 flex-wrap">
                @foreach($ads as $ad)
                    <div class="col-sm-4 d-flex pb-3">
                        <div class="card mb-4 shadow-sm">

                            @if(count(Storage::disk('public')->files('uploads/'.$ad->user->id.'/'.$ad->id))>0)
                                <img class="bd-placeholder-img card-img-top" width="100%" height="225"
                                     src="{{asset('storage/'.Storage::disk('public')->files('uploads/'.$ad->user->id.'/'.$ad->id)[0])}}"/>
                            @else
                                <svg class="bd-placeholder-img card-img-top" width="100%" height="225"
                                     xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice"
                                     focusable="false"
                                     role="img">

                                    <rect width="100%" height="100%" fill="#55595c"></rect>
                                    <text x="50%" y="50%" fill="#eceeef"
                                          dy=".3em"></text>
                                </svg>
                            @endif
                            <h3 style="position: absolute;"><span
                                    class="badge badge-secondary">{{$ad->category->name}}</span></h3>
                            <div class="card-body">
                                <div class="row">

                                    <div class="col">
                                        <h2 class="card-title">{{$ad->name}}</h2>
                                    </div>
                                    <div class="col">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('ad',['id'=>$ad->id]) }}" type="button"
                                               class="btn btn-sm btn-primary">Открыть</a>
                                            <a href="{{route('ad.moderation',['id'=>$ad->id])}}"
                                               class="btn btn-sm btn-success"
                                               type="button">Модерация</a>
                                        </div>
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
