@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Список пользователей') }}</div>
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
                                            <!--<button type="button" class="btn btn-primary"><i class="fa fa-eye"></i></button>-->
                                            <a href="{{route('admin.edit_user',['id'=>$user->id])}}" type="button" class="btn btn-success"><i class="fa fa-edit"></i></a>
                                            <form action="{{ route('admin.delete_user',['id'=>$user->id]) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                            <button type="submit" class="btn btn-danger"><i class="fa fa-trash "></i></button>
                                            </form>
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
    </div>
@endsection
