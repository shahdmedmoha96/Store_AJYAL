@if ($errors->any())
    <div class="alert alert-danger ">
        <h3>Error Occured!</h3>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    </div>


@endif

<div class="mb-3 form-group">
    <x-form.input label="product Name" type='text' name='name' value="{{$product->name}}"/>
  </div>
<div class="mb-3">
  <label class="form-label">Category</label>
  <select name="parent_id" class="form-control form-select" >
    <option value="">Primary product</option>
    @foreach ($parents as $parent)
    <option value=" {{$parent->id }}" @selected(old('name',$product->category_id)==$parent->id)>{{$parent->name }}</option>

    @endforeach
  </select>
  @error('parent_id')
  <p class="text text-danger">{{ $message }}</p>
@enderror
</div>
<div class="mb-3 form-group">

    <x-form.textarea label="product description" type='text' name='description' value="{{$product->description}}"/>
  </div>
  <div class="mb-3 form-group">
    <x-form.input label="product Image" type='file' name='image' value="{{$product->image}}"/>
    @if ($product->image)
    <img src="{{asset('storage/'. $product->image)}}" alt=""  height="80">
    @endif
  </div>
  <div class="mb-3 form-group">
    <x-form.input label="product price" type='number' name='price' value="{{$product->price}}"/>
  </div>
  <div class="mb-3 form-group">
    <x-form.input label="product Compare price" type='number' name='compare_price' value="{{$product->compare_price}}"/>
  </div>
  <div class="mb-3 form-group">
    <x-form.input label="product tags" type='text' name='tags' value="{{$tags}}"/>
  </div>
  <div class="mb-3 form-group">
<label class="form-label">product Status</label>
    <x-form.radio  name="status"  checked="{{$product->status}}" :options="['active'=>'Active', 'archvied'=>'Archvied','draft'=>'Draft']"/>

      </div>

  </div>
 @push('styles')
    <!-- Link to your stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
@endpush



@push('script')
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.polyfills.min.js"></script>
<script >
var input = document.querySelector('input[name=tags]');

// initialize Tagify on the above input node reference
new Tagify(input)
</script>

@endpush
