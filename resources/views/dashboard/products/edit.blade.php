@extends('layouts.dashboard')
@section('title','Edit product ')
@section('content')
<form action="{{route("products.update",$product->id)}}" method="POST"  enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <form>
      @include('dashboard.products._form')
        <button type="submit" class="btn btn-primary">Updata</button>
      </form>
</form>

@endsection
