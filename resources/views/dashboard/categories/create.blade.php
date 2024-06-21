@extends('layouts.dashboard')
@section('title','Categories Pager')
@section('content')
<form action="{{route("categories.store")}}" method="POST" enctype="multipart/form-data">
    @csrf
    <form>
        @include('dashboard.categories._form')
        <button type="submit" class="btn btn-primary">Create</button>
      </form>
</form>

@endsection
