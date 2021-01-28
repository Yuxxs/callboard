@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        @if(count($categories)>1)
                        @foreach($categories as $category)
                            <div class="card-header" ><a href="{{route('user.choose_category',['id'=>$category->id])}}">{{ $category->name }}</a></div>
                            <div class="card-body">
                                @foreach($category->children as $subcategory)
                                || <a>{{$subcategory->name}}</a>
                                @endforeach
                            </div>
                        @endforeach
                        @else
                        @foreach($categories as $category)
                        <div class="card-header" ><a href="{{route('user.choose_category',['id'=>$category->id])}}">{{ $category->name }}</a></div>
                        <div class="card-body">
                            <ul class="list-group">
                                @foreach($category->children as $subcategory)   
                               <a href="{{route('user.choose_category',['id'=>$subcategory->id])}}">
                                    <li class="list-group-item">{{$subcategory->name}}</li>
                               </a>
                                @endforeach
                            </ul>
                        </div>
                        @endforeach
                        @endif
                       </div>
                   </div>
               </div>
           </div>
       </div>
   @endsection
