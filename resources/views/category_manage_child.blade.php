<div class="dropdown-menu">
    @foreach ($categories as $category)
    @if(count($category->children)==0)
    <a class="dropdown-item" href="{{route('ad.search',['category_id'=>$category->id])}}">{{$category->name}}</a>
    @else
    <a class="dropdown-item submenu" href="{{route('ad.search',['category_id'=>$category->id])}}">{{$category->name}}</a>
    @include('category_manage_child',['categories' => $category->children])
    @endif
    @endforeach
</div>