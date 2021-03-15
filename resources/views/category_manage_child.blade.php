<div class="dropdown-menu">
    @foreach ($categories as $category)
    @if(count($category->children)==0)
    <a class="dropdown-item"  onclick='document.getElementById("category_slug").value="{{$category->slug}}";document.getElementById("category_dropdown_button").innerText="{{$category->name}}"'>{{$category->name}}</a>
    @else
    <a class="dropdown-item submenu"  onclick='document.getElementById("category_slug").value="{{$category->slug}}";document.getElementById("category_dropdown_button").innerText="{{$category->name}}"'>{{$category->name}}</a>
    @include('category_manage_child',['categories' => $category->children])
    @endif
    @endforeach
</div>
