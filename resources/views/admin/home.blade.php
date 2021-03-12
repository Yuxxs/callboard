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
                        Список пользователей
                    </h2>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">

                       <a href="{{ route('admin.edit_user') }}" class="btn btn-xs btn-info ">Создать пользователя</a>
                        <p>
                        <div class="row-md-12">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">№</th>
                                    <th scope="col">ФИО</th>
                                    <th scope="col">Телефон</th>
                                    <th scope="col">E-mail</th>
                                    <th scope="col">Роль</th>
                                    <th scope="col">Статус</th>
                                    <th scope="col">Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $key => $user)
                                    <tr>
                                        <th scope="row">{{ ++$key }}</th>
                                        <td>{{ $user->name .' '.$user->middlename.' '.$user->surname}}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->role->name }}</td>
                                        <td>{{ $user->status->name }}</td>
                                        <td>
                                            <div class="btn-group">
                                            <a href="{{route('user.profile',['id'=>$user->id])}}" type="button" class="btn btn-primary"><i class="fa fa-eye"></i></a>
                                            <a href="{{route('admin.edit_user',['id'=>$user->id])}}" type="button" class="btn btn-success"><i class="fa fa-edit"></i></a>
                                            <form action="{{ route('admin.delete_user',['id'=>$user->id]) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                            <button type="submit" class="btn btn-danger"><i class="fa fa-trash "></i></button>
                                            </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row equal">
            <div class="col-sm-8 d-flex pb-3 flex-wrap">

            </div>
        </div>
        <div class="row equal">
            <div class="col-sm-8 d-flex pb-3 flex-wrap">
                <div class="p-2 bd-highlight">
                    <h2 class="font-weight-light text-center text-lg-left mt-4 mb-0">
                     Обьявления на модерацию
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
