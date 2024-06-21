{{--
@if (isset($label))
<label class="form-label">{{$label}}</label>

@endif

<input name='{{$name}}' type="{{$type ??'text'}}"
value="{{old($name, $value ) }}"
@if (isset($placeholder))
placeholder="{{$placeholder}}"
@endif
class="form-control
 @error($name) is-invalid @enderror"
>
@error($name)
<p class="text text-danger">{{ $message }}</p>
@enderror --}}

@if (isset($label))
    <label class="form-label">{{$label}}</label>
@endif

<input name='{{$name}}' type="{{ isset($type) ? $type : 'text' }}"
       value="{{ old($name, $value ) }}"
       @if (isset($placeholder)) placeholder="{{$placeholder}}" @endif
       class="form-control @error($name) is-invalid @enderror">
@error($name)
    <p class="text text-danger">{{ $message }}</p>
@enderror
