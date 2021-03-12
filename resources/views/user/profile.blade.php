@extends('layouts.app')

@section('content')
    <div class="container">

            <div class="col-md-10">
                <div class="card-body  mt-2 " style="border-radius: 12px;">
                    <table class="table table-th-block bg-light text-dark">
                        <tbody>
                        <tr>
                            <td class="active">ФИО</td>
                            <td>     {{$user->surname.' '.$user->name.' '.$user->middlename}}</td>
                        </tr>
                        <tr>
                            <td class="active">Телефон</td>
                            <td>{{$user->phone}}</td>
                        </tr>
                        <tr>
                            <td class="active">E-mail</td>
                            <td>{{$user->email}}</td>
                        </tr>

                        @if(Auth::user()->role->slug=='admin')
                            <tr>
                                <td class="active">Роль</td>
                                <td>{{$user->role->name}}</td>
                            </tr>
                            <tr>
                                <td class="active">Статус</td>
                                <td>{{$user->status->name}}</td>
                            </tr>
                        @endif

                    </table>


                </div>
            </div>

    </div>
@endsection
