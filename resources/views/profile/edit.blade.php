<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>
<div class="container mt-3">
    <x-alert type='success'/>

    <form action="{{route("profile.update")}}" method="POST"  enctype="multipart/form-data">
        @csrf
        @method('patch')
     <div class="row">
        <div class="mb-3 form-group col">
            <x-form.input  name='first_name' label='First Name' :value="$user->profile->first_name"/>
        </div>
        <div class="mb-3 form-group col">
            <x-form.input  name='last_name' label='Lastt Name' :value="$user->profile->last_name"/>
        </div>
     </div>
     <div class="row">
        <div class="mb-3 form-group col">
            <x-form.input  name='birthday' type="data" label=' Birthday' placeholder="mm/dd/yyyy" :value="$user->profile->birthday"/>
        </div>
        <div class="mb-3 form-group col">
<label class="form-label">Gender</label>

            <x-form.radio  name='gender'  :value="$user->profile->gender" checked="{{$user->profile->gender}}" :options="['male'=>'Male','female'=>'Female']"/>
        </div>
     </div>
     <div class="row">
        <div class="mb-3 form-group col">
            <x-form.input  name='street_address' label='Street Address ' :value="$user->profile->street_address"/>
        </div>
        <div class="mb-3 form-group col">
            <x-form.input  name='city' label=' City ' :value="$user->profile->city"/>
        </div>
        <div class="mb-3 form-group col">
            <x-form.input  name='state' label='State ' :value="$user->profile->state"/>
        </div>
     </div>
     <div class="row">
        <div class="mb-3 form-group col">
            <x-form.input  name='postal_code' label=' Postal Code ' :value="$user->profile->postal_code"/>
        </div>
        <div class="mb-3 form-group col">
            <label >Country</label>
            <x-form.select  name='country'  :selected="$user->profile->country" :options="$counties"/>
        </div>
        <div class="mb-3 form-group col">
            <label >Local</label>
            <x-form.select  name='local'  :selected="$user->profile->local" :options="$locals"/>
        </div>
     </div>


            <button type="submit" class="btn btn-primary">Updata</button>
              </form>
 </div>
</x-app-layout>
