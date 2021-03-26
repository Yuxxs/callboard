@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col" id="content">

                <div class="d-flex bd-highlight mb-3">
                    <div class="p-2 bd-highlight">
                        <h1 class="font-weight-light text-center text-lg-left mt-4 mb-0">{{$ad->name}}</h1>
                    </div>

                    @if(Auth::check())
                        @if(Auth::user()->id==$ad->user->id)
                            @if($ad->status->slug=='sketch')
                                <div class="p-2 bd-highlight">
                                    <form action="{{route('user.send_ad',['id'=>$ad->id])}}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">Опубликовать</button>
                                    </form>
                                </div>
                            @endif
                            <div class="p-2 bd-highlight">
                                <a href="{{ route('user.edit_ad',['ad'=>$ad->toArray()]) }}" type="button"
                                   class="btn btn-primary">Изменить</a>
                            </div>
                            <div class="p-2 bd-highlight">
                                <form action="{{ route('user.delete_ad',['id'=>$ad->id]) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit"
                                            class="btn btn-primary"> Удалить
                                    </button>
                                </form>

                            </div>
                        @endif
                        @if(Auth::user()->id==$ad->user->id||Auth::user()->role->slug=='moderator')
                            <div class="ml-auto p-2 bd-highlight">
                                <a href="{{route('ad.moderation',['id'=>$ad->id])}}" class="btn btn-primary"
                                   type="button">Панель
                                    модерации</a>
                            </div>
                        @endif
                    @endif


                </div>

                <div class="row">
                    <div id="carouselExampleControls" class="carousel slide " data-ride="carousel">
                        <div class="carousel-inner">
                            @for ($i = 0; $i < count(Storage::disk('public')->files('uploads/'.$ad->user->id.'/'.$ad->id)); $i++)

                                <div class="carousel-item @if($i==0) active @endif">
                                    <img class="img-fluid img-thumbnail" style =" width:800px; height:500px; object-fit:  contain;"
                                         src="{{asset('storage/'.Storage::disk('public')->files('uploads/'.$ad->user->id.'/'.$ad->id)[$i])}}"/>
                                </div>
                            @endfor
                                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                                    <span style="color: Mediumslateblue;">
                                   <i class="fa fa-arrow-left fa-2x "></i>
                                        </span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                                     <span style="color: Mediumslateblue;">
                                   <i class="fa fa-arrow-right fa-2x "></i>
                                        </span>
                                    <span class="sr-only">Next</span>
                                </a>
                        </div>
                    </div>
                </div>

                <hr class="mt-2 mb-5">
                <div class="row">
                    <div class="col-md-3">

                        <div class="">
                            <h5>Местоположение</h5>
                        </div>
                    </div>
                    <div class="col-md-2">

                        <div class="text-nowrap" style="width: 20rem;">
                            <p>{{$ad->city->region->country->name}}, {{$ad->city->region->name}}
                                , {{$ad->city->name}}</p>
                        </div>
                    </div>
                </div>
                <hr class="mt-2 mb-5">
                <div class="row">
                    <div class="col-md-3">

                        <div class="">
                            <h5>Описание</h5>
                        </div>
                    </div>
                    <div class="col-md-2">

                        <div class="text-nowrap" style="width: 20rem;">
                            <p>{{$ad->description}}</p>
                        </div>
                    </div>
                </div>
                <hr class="mt-2 mb-5">

                <div class="row">
                    <div class="col-md-3">
                        <div class="">
                            <h5>Категория</h5>
                        </div>
                    </div>
                    <div class="col-md-2">

                        <div class="text-nowrap">
                            <p>@if($ad->category->parent){{$ad->category->parent->name}}@else{{$ad->category->name}}@endif</p>
                        </div>
                    </div>
                </div>
                @if($ad->category->parent)
                    <div class="row">
                        <div class="col-md-3">
                            <div class="">
                                <h5>Подкатегория</h5>
                            </div>
                        </div>
                        <div class="col-md-2">

                            <div class="text-nowrap">
                                <p>{{$ad->category->name}}</p>
                            </div>
                        </div>
                    </div>
                @endif
                <hr class="mt-2 mb-5">
                <div class="row">
                    <div class="col-md-3">
                        <div class="">
                            <h5>Просмотры</h5>
                        </div>
                    </div>
                    <div class="col-md-2">

                        <div class="text-nowrap">
                            <p>{{$ad->views_count}}</p>
                        </div>
                    </div>
                </div>
            </div>


        </div>

@endsection
