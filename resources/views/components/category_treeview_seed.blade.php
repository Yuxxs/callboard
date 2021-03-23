@foreach($categories as $category)
    @if(count($category->children)==0)
        <li>
            <div class="btn-group mb-2">
                <button class="btn btn-secondary selector" type="button">{{$category->name}}</button>
                <button class="btn btn-success create-selector"><i class="fa fa-plus"></i></button>
                <form action="{{ route('admin.delete_category',['id'=>$category->id]) }}"
                      method="POST">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-danger"><i
                            class="fa fa-trash "></i></button>
                </form>

                <!-- Data for substitution-->
                <p class="d-none"  name="update_url">
                    {{ route('admin.save_category',['id'=>$category->id]) }}
                </p>
                <p class="d-none"  name="id">
                    {{$category->id}}
                </p>
                <p class="d-none"  name="name">
                    {{$category->name}}
                </p>
                <p class="d-none"  name="slug">
                    {{$category->slug}}
                </p>
                <p class="d-none" name="description">
                    {{$category->description??''}}
                </p>
            </div>
        </li>
    @else
        <li>
            <div class="btn-group mb-2">
                <button class="btn btn-outline-secondary caret"></button>
                <button  class="btn btn-secondary selector" type="button">{{$category->name}}</button>
                <button class="btn btn-success create-selector"><i class="fa fa-plus"></i></button>
                <form action="{{ route('admin.delete_category',['id'=>$category->id]) }}"
                      method="POST">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-danger"><i
                            class="fa fa-trash "></i></button>
                </form>
                <!-- Data for substitution-->
                <p class="d-none"  name="update_url">
                    {{ route('admin.save_category',['id'=>$category->id]) }}
                </p>
                <p class="d-none"  name="id">
                    {{$category->id}}
                </p>
                <p class="d-none"  name="name">
                    {{$category->name}}
                </p>
                <p class="d-none"  name="slug">
                    {{$category->slug}}
                </p>
                <p class="d-none" name="description">
                    {{$category->description??''}}
                </p>
            </div>
            <ul class="nested">
                @include('components.category_treeview_seed',['categories'=>$category->children])
            </ul>
        </li>
    @endif
@endforeach
