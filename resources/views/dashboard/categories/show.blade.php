@extends('layouts.dashboard')
@section('title',ucfirst( $category->name)." Category")
@section('content')
<table class="table  mt-2 text-center">
    <thead>

        <tr>
            <th>Image</th>
            <th>Name</th>
            <th>Store</th>
            <th>Status</th>
            <th>Created At</th>
        </tr>
    </thead>
    <thead>

        @if ($category->count())
        @php
        $products=$category->products()->with('store')->latest()->paginate(5);
    @endphp
        @foreach ($products as $product)
        <tr class="text-center">
           <th><img src="{{asset('storage/'. $product->image)}}" alt=""  height="50"></th>
            <th>{{$product->name}}</th>
            <th>{{$product->store->name}}</th>
            <th>{{$product->status}}</th>
            <th>{{$product->created_at}}</th>
        </tr>
        @endforeach
        @else
            <tr>
                <td colspan="5" >
                    <h4 class="text-center mt-4" >No Categories Defined.</h4>
                </td>

            </tr>
        @endif


    </thead>
</table>
{{$products->links()}}
@endsection
