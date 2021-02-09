@extends('layouts.app')

@section('content')

<div class="row equal">


  <nav class="col-md-2  sidebar border-right bg-light rounded-right">

    <div class="sidebar-header">
      <h3>Меню</h3>
    </div>
    <div class="bg-light border-right" id="sidebar-wrapper">

      <div class="list-group list-group-flush">
        <a href="{{route('user.choose_category')}}" class="list-group-item list-group-item-action bg-light">Создать
          обьявление</a>

      </div>
    </div>
  </nav>

  <div class="col-sm-8 d-flex pb-3 flex-wrap">
    @foreach($ads as $ad)
    <div class="col-sm-4 d-flex pb-3">
      <div class="card mb-4 shadow-sm">

        @if(count(Storage::disk('public')->files('uploads/'.$ad->user->id.'/'.$ad->id))>0)
        <img class="bd-placeholder-img card-img-top" width="100%" height="225"
          src="{{asset('storage/'.Storage::disk('public')->files('uploads/'.$ad->user->id.'/'.$ad->id)[0])}}" />
        @else
        <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg"
          preserveAspectRatio="xMidYMid slice" focusable="false" role="img">

          <rect width="100%" height="100%" fill="#55595c"></rect><text x="50%" y="50%" fill="#eceeef" dy=".3em">
        </svg>
        @endif
        <h3 style="position: absolute ;"><span class="badge badge-secondary">{{$ad->city->name}}</span></h3>

        <div class="card-body">
          <div class="row">
            <div class="col">
              <h2 class="card-title">{{$ad->cost}}&#8381</h2>
            </div>
            <div class="col">
              <form action="{{ route('user.delete_ad',['id'=>$ad->id]) }}" method="POST">
                @method('DELETE')
                @csrf
              <button type="submit"
                class="btn btn-danger close"><span aria-hidden="true">&times;</span></button>
              </form>
            </div>
          </div>
          <h4 class="card-texttext-truncate" style="width: 17rem;">{{$ad->name}}</h4>
          <div class="d-flex justify-content-between align-items-center">
            <div class="btn-group">
              <a href="{{ route('ad',['id'=>$ad->id]) }}" type="button"
                class="btn btn-sm btn-outline-secondary">Открыть</a>
              <a href="{{ route('user.edit_ad',['ad'=>$ad->toArray()]) }}" type="button"
                class="btn btn-sm btn-outline-secondary">Изменить</a>

            </div>
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