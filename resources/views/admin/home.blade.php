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
            <div class="col">
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
                                                <a href="{{route('user.profile',['id'=>$user->id])}}" type="button"
                                                   class="btn btn-primary"><i class="fa fa-eye"></i></a>
                                                <a href="{{route('admin.edit_user',['id'=>$user->id])}}" type="button"
                                                   class="btn btn-success"><i class="fa fa-edit"></i></a>
                                                <form action="{{ route('admin.delete_user',['id'=>$user->id]) }}"
                                                      method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger"><i
                                                            class="fa fa-trash "></i></button>
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
                <div class="p-2 bd-highlight">
                    <h2 class="font-weight-light text-center text-lg-left mt-4 mb-0">
                        Редактирование категорий
                    </h2>
                </div>
            </div>
        </div>
        <hr class="mt-2 mb-5">
        <div class="row equal">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <div class="p-2 bd-highlight"><h4>Список категорий</h4></div>
                            <div class="p-2 bd-highlight">
                                <button type="submit" name='submit' class="btn btn-success selector">
                                    Новая корневая категория
                                </button>
                                <!-- Data for substitution-->
                                <p class="d-none" name="update_url">
                                    {{route('admin.save_category')}}
                                </p>
                                <p class="d-none" name="id">
                                </p>
                                <p class="d-none" name="name">
                                </p>
                                <p class="d-none" name="slug">
                                </p>
                                <p class="d-none" name="description">
                                </p>

                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="overflow-auto">
                            <ul id="myUL">
                                @include('components.category_treeview_seed',['categories'=>$categories])
                            </ul>
                            <script>
                                $(document).ready(function () {
                                    var toggler = $(".caret");
                                    var i;

                                    for (i = 0; i < toggler.length; i++) {
                                        toggler[i].addEventListener("click", function () {
                                            this.parentElement.parentElement.querySelector(".nested").classList.toggle("active");
                                            this.classList.toggle("caret-down");
                                        });
                                    }

                                    var selector = $(".selector");
                                    for (i = 0; i < selector.length; i++) {
                                        selector[i].addEventListener("click", function () {
                                            $("#category_form_header").text("Редактирование категории");
                                            var value_container = this.parentElement;
                                            $("#category_form").attr('action',value_container.querySelector('p[name="update_url"]').innerText.trim());

                                            $("#category_form_name").val(value_container.querySelector('p[name="name"]').innerText.trim());
                                            $("#category_form_slug").val(value_container.querySelector('p[name="slug"]').innerText.trim());
                                            $("#category_form_description").val(value_container.querySelector('p[name="description"]').innerText.trim());
                                        });
                                    }

                                    var create_selector = $(".create-selector");
                                    for (i = 0; i < create_selector.length; i++) {
                                        create_selector[i].addEventListener("click", function () {
                                            var value_container = this.parentElement;
                                            $("#category_form_header").text('Новая подкатегория в категории "' + value_container.querySelector('p[name="name"]').innerText.trim() + '"');
                                            $("#category_form").attr('action', "{{route('admin.save_category')}}");

                                            $("#category_form_parent_id").val(value_container.querySelector('p[name="id"]').innerText.trim());
                                            $("#category_form_name").val('');
                                            $("#category_form_slug").val('');
                                            $("#category_form_description").val('');
                                        });
                                    }
                                });

                            </script>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-header" id="category_form_header">
                        Новая категория
                    </div>
                    <div class="card-body">
                        <form id="category_form" method="POST" action="{{ route('admin.save_category') }}">
                            @csrf
                            <input type="hidden" name="parent_id" id="category_form_parent_id">
                            <div class="form-group row">
                                <label for="name"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Наименование') }}</label>

                                <div class="col-md-6">
                                    <input id="category_form_name" type="text"
                                           class="form-control @error('name') is-invalid @enderror"
                                           name="name" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="slug"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Slug') }}</label>

                                <div class="col-md-6">
                                    <input id="category_form_slug" type="slug"
                                           class="form-control @error('slug') is-invalid @enderror"
                                           name="slug" required autocomplete="slug" autofocus>

                                    @error('slug')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Описание') }}</label>

                                <div class="col-md-6">
                                <textarea class="form-control rounded-0 @error('description') is-invalid @enderror"
                                          rows="2" id="category_form_description" name="description"
                                          autocomplete="description"
                                          autofocus></textarea>
                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" name='submit' class="btn btn-primary">
                                        {{ __('Сохранить') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
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
