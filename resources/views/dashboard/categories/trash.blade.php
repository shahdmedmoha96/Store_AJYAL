@extends('layouts.dashboard')
@section('title',' Trashed Categories ')
@section('content')
<div class="mb-5 d-inline d-flex justify-content-between  align-items-center">
    <a href="{{route('categories.index')}}" class="btn btn-sm btn-outline-primary">Back</a>
    <form method="GET" action="{{URL::current()}}" class="d-flex justify-content-between  align-items-center">
   <x-form.input name="name"  placeholder="Search" :value="request('name')"/>
   <select name="status" id="" class="form-control">
<option value="">All</option>
<option  @selected(request('status')=='active') value="active">Active</option>
<option  @selected(request('status')=='inactive') value="inactive">Inactive</option>
   </select>
   <button  class="btn btn-dark" type="submit">Filter</button>
</form>

</div>
<x-alert type='success'/>
<x-alert type='info'/>
<x-alert type='danger'/>
<table class="table  mt-2 text-center">
    <thead>

        <tr>
            <th>Image</th>
            <th>ID</th>
            <th>Name</th>
            <th>Status</th>
            <th>Deleted At</th>
            <th colspan="2">Action</th>

        </tr>
    </thead>
    <thead>
        @if ($categories->count())
        @foreach ($categories as $category)
        <tr class="text-center">
            <th><img src="{{asset('storage/'. $category->image)}}" alt=""  height="50"></th>
            <th>{{$category->id}}</th>
            <th>{{$category->name}}</th>
            <th>{{$category->status}}</th>
            <th>{{$category->deleted_at}}</th>
            {{-- <th>
                <a href="{{route('categories.edit',$category->id)}}" class="btn btn-sm btn-outline-success">Edit</a>

             </th> --}}
            <th>
                <form action="{{route('categories.restore',$category->id)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <button class="btn btn-sm btn-outline-info">Restore</button>
                </form>
             </th>
             <th>
                <form action="{{route('categories.forceDelete',$category->id)}}" method="POST">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-outline-danger">ForceDelete</button>
            </form>
             </th>
        </tr>
        @endforeach
        @else
            <tr>
                <td colspan="6" >
                    <h4 class="text-center mt-4" >No Categories Defined.</h4>
                </td>

            </tr>
        @endif


    </thead>
</table>

{{$categories->withQueryString()->links()}}
@endsection
