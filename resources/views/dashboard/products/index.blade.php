@extends('layouts.dashboard')
@section('title','Products Pager')
@section('content')
<div class="mb-5 d-inline d-flex justify-content-between  align-items-center">
    <a href="{{route('products.create')}}" class="btn btn-sm btn-outline-primary">Create Product</a>
    {{-- <a href="{{route('products.trash')}}" class="btn btn-sm btn-outline-dark">Trashed product</a> --}}


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
            <th>Category</th>
            <th>Store</th>
            <th>Status</th>
            <th>Created At</th>
            <th colspan="2">Action</th>

        </tr>
    </thead>
    <thead>
        @if ($products->count())
        @foreach ($products as $product)
        <tr class="text-center">
            <th><img src="{{asset('storage/'. $product->image)}}" alt=""  height="50"></th>
            <th>{{$product->id}}</th>
            <th>{{$product->name}}</th>
            @if ($product->category)
                 <th>{{$product->category->name}}</th>
             @endif
            <th>{{$product->store->name}}</th>
            <th>{{$product->status}}</th>
            <th>{{$product->created_at}}</th>
            <th>
                <a href="{{route('products.edit',$product->id)}}" class="btn btn-sm btn-outline-success">Edit</a>

             </th>
             <th>
                <form action="{{route('products.destroy',$product->id)}}" method="POST">
                @csrf
                @method('DELETE')
                <button class="btn btn-sm btn-outline-danger">delete</button>
            </form>
             </th>
        </tr>
        @endforeach
        @else
            <tr>
                <td colspan="9" >
                    <h4 class="text-center mt-4" >No products Defined.</h4>
                </td>

            </tr>
        @endif


    </thead>
</table>

{{$products->withQueryString()->links()}}
@endsection
