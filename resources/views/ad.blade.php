@extends('layouts.app')
@section('content')
<div class="row">
  
    <nav class="col-md-2  sidebar border-right bg-light rounded-right">
        
        <div class="bg-light border-right" id="sidebar-wrapper">
           
            <div class="list-group list-group-flush">
              <a href="#" class="list-group-item list-group-item-action bg-light">Dashboard</a>
              <a href="#" class="list-group-item list-group-item-action bg-light">Shortcuts</a>
              <a href="#" class="list-group-item list-group-item-action bg-light">Overview</a>
              <a href="#" class="list-group-item list-group-item-action bg-light">Events</a>
              <a href="#" class="list-group-item list-group-item-action bg-light">Profile</a>
              <a href="#" class="list-group-item list-group-item-action bg-light">Status</a>
            </div>
          </div>
    </nav>
    <div class="col-md-8">



        <h1 class="font-weight-light text-center text-lg-left mt-4 mb-0">{{$ad->name}}</h1>
        <hr class="mt-2 mb-5">
        <div class="row text-center text-lg-left">
            @for ($i = 0; $i < count(Storage::disk('public')->files('uploads/'.Auth::user()->id.'/'.$ad->id)); $i++)
                <div class="col-lg-3 col-md-4 col-6">
                    <img class="img-fluid img-thumbnail" width="100%" height="225"
                        src="{{asset('storage/'.Storage::disk('public')->files('uploads/'.Auth::user()->id.'/'.$ad->id)[$i])}}" />
                </div>
                @endfor
        </div>


    </div>
</div>
@endsection