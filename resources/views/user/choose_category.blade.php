@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">

                @if($category??false)

                    <div class="card ">
                        <div class="card-header">{{ $category->name }}</div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                @foreach($category->children as $subcategory)
                                    <a href="{{route('user.choose_category',['ad'=>$ad,'category_id'=>$subcategory->id])}}">
                                        <li class="list-group-item">{{$subcategory->name}}</li>
                                    </a>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                @else
                    @foreach($categories as $category)

                        <div class="card">

                            <div class="card-header">
                                <a href="{{route('user.choose_category',['ad'=>$ad,'category_id'=>$category->id])}}">
                                    {{ $category->name }}
                                </a>
                            </div>
                            <div class="card-body">
                                @foreach($category->children as $subcategory)
                                    ||
                                    <a href="{{route('user.choose_category',['ad'=>$ad,'category_id'=>$subcategory->id])}}">
                                        {{$subcategory->name}}
                                    </a>
                                @endforeach

                            </div>
                        </div>
                        <p>
                    @endforeach

                @endif
            </div>

        </div>
    </div>
@endsection
