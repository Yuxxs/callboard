<div>
    <select class="selectpicker form-control "
            title="Город"
            data-hide-disabled="true"
            id="city_slug"
            name="city_slug"
            data-live-search="true">
      @foreach($cities as $city)
            <option  value="{{$city->slug}}" @if($city->slug==$city_slug) selected @endif>{{$city->name}}</option>
        @endforeach
    </select>

    <script>
        $(document).ready(function () {
            $.fn.selectpicker.Constructor.BootstrapVersion = '4';
            $('.selectpicker').selectpicker();
            $('.selectpicker').selectpicker('refresh');

        });
    </script>
</div>
<!-- /.row -->
