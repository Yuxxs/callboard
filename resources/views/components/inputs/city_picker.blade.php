<div>
    <select class="form-control"
            title="Город"
            data-hide-disabled="true"
            id="city_slug"
            name="city_slug"
            data-live-search="true" style="width:auto;">
      @foreach($cities as $city)
            <option  value="{{$city->slug}}" @if($city->slug==$city_slug) selected @endif>{{$city->name}}</option>
        @endforeach
    </select>

</div>

