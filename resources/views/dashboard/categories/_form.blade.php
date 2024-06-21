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
    <x-form.input label="Category Name" type='text' name='name' value="{{$category->name}}"/>
  </div>
<div class="mb-3">
  <label class="form-label">Category Parent</label>
  <select name="parent_id" class="form-control form-select" >
    <option value="">Primary Category</option>
    @foreach ($parents as $parent)
    <option value=" {{$parent->id }}" @selected(old('name',$category->parent_id)==$parent->id)>{{$parent->name }}</option>

    @endforeach
  </select>
  @error('parent_id')
  <p class="text text-danger">{{ $message }}</p>
@enderror
</div>
<div class="mb-3 form-group">

    <x-form.textarea label="Category description" type='text' name='description' value="{{$category->description}}"/>
  </div>
  <div class="mb-3 form-group">


    <x-form.input label="Category Image" type='file' name='image' value="{{$category->image}}"/>
    @if ($category->image)
    <img src="{{asset('storage/'. $category->image)}}" alt=""  height="80">
    @endif
  </div>
  <div class="mb-3 form-group">
<label class="form-label">Category Status</label>
    <x-form.radio  name="status"  checked="{{$category->status}}" :options="['active'=>'Active', 'inactive'=>'Inactive']"/>

      </div>

  </div>
