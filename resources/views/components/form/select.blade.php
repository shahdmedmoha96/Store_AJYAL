<select
class="form-control form-select  @error($name) is-invalid @enderror"
 name={{{$name}}} >
  @foreach ($options as $value=>$text)
<option value="{{$value}}"
@isset($selected)
@selected($value==$selected)
@endisset >{{$text}}</option>
  @endforeach

</select>
{{-- <h2>ll</h2> --}}
