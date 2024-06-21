
@if ($label)
<label class="form-label">{{$label}}</label>

@endif
<textarea class="form-control
@error($name)
is-invalid
 @enderror" >{{old($name,$value) }}</textarea>
@error($name)
<p class="text text-danger">{{ $message }}</p>
@enderror
