@extends('layouts.app')

@section('content')
@if($current_category??false)
<div class="row equal">
    <div class="col-sm-8 d-flex pb-3 flex-wrap">
        
    </div>
</div>
<div class="row equal">
    <div class="col-sm-8 d-flex pb-3 flex-wrap">
        <div class="p-2 bd-highlight">
            <h2 class="font-weight-light text-center text-lg-left mt-4 mb-0">{{$current_category->name}}</h2>
        </div>
    </div>
</div>

<hr class="mt-2 mb-5">
@endif
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
                <h3 style="position: absolute ;"><span class="badge badge-secondary">{{$ad->city->name}}</span></h3>

                <div class="card-body">
                    <h2 class="card-title">{{$ad->cost}}&#8381</h2>
                    <h4 class="card-texttext-truncate" style="width: 17rem;">{{$ad->name}}</h4>
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('ad',['id'=>$ad->id]) }}" type="button"
                            class="btn btn-sm btn-outline-secondary">Открыть</a>
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