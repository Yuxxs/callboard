@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>
                    <div class="card-body">


                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>
                    <div class="card-body">
                        <a href="{{ route('user.choose_category') }}" class="btn btn-xs btn-info ">Создать объявление</a>
                        <p>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
