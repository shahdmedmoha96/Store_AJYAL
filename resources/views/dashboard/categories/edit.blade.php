@extends('layouts.dashboard')
@section('title','Edit Category ')
@section('content')
<form action="{{route("categories.update",$category->id)}}" method="POST"  enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <form>
      @include('dashboard.categories._form')
        <button type="submit" class="btn btn-primary">Updata</button>
      </form>
</form>

@endsection
