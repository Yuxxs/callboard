@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Список пользователей') }}</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">№</th>
                                    <th scope="col">ФИО</th>
                                    <th scope="col">Телефон</th>
                                    <th scope="col">E-mail</th>
                                    <th scope="col">Роль</th>
                                    <th scope="col">Статус</th>
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
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
