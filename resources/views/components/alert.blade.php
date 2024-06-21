@if (session()->has($type))

    <div class="alert alert-{{$type}} mt-3" role="alert">
        {{ session($type) }}
      </div>
@endif
