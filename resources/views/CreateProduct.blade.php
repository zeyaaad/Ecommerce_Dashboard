@extends('layouts.layout');

@section("title" , "Create Product") ;

@section("content")

    <div class="card w-100">
        @include("layouts.message")

        <form action="{{ route("product.store") }}" enctype="multipart/form-data" method="POST" class="p-3">
            @csrf
            <div class="form-group">
                <label for="name">Product Name:</label>
                <input type="text" name="name" value="{{ old("name") }}" class="form-control">
                 @error("name")
                 <div class="alert alert-danger mt-1">
                    {{ $message }}
                 </div>

                 @enderror
            </div>
            <div class="row">
                <div class="form-group col-6">
                    <label for="price">Price :</label>
                    <input value="{{ old("price") }}" type="text" name="price" class="form-control">
                 @error("price")
                    <div class="alert alert-danger mt-1">
                        {{ $message }}
                    </div>
                 @enderror
                </div>
                <div class="form-group col-6">
                    <label for="quantity">Quantity  :</label>
                    <input value="{{ old("quantity") }}" type="text" name="quantity" class="form-control">
                    @error("quantity")
                    <div class="alert alert-danger mt-1">
                        {{ $message }}
                    </div>
                 @enderror
                </div>
            </div>
            <div class="row">
                <div class="form-group col-6">
                    <label for="category">Category :</label>
                    <select name="category" class="form-control">
                        @foreach ($Categories as $cat )
                        <option {{ old("category")== $cat->cat_id? "selected" :"" }} value="{{ $cat->cat_id }}">{{ $cat->name}}</option>
                        @endforeach
                    </select>
                    @error("category")
                    <div class="alert alert-danger mt-1">
                        {{ $message }}
                    </div>
                 @enderror
                </div>
                <div class="form-group col-6">
                    <label for="brand">Brand:</label>
                  <select name="brand" class="form-control">
                        @foreach ($Brands as $brand )
                        <option  {{ old("brand")== $brand->brand_id?"selected" :"" }} value="{{ $brand->brand_id }}">{{ $brand->name}}</option>
                        @endforeach
                    </select>
                    @error("brand")
                    <div class="alert alert-danger mt-1">
                        {{ $message }}
                    </div>
                 @enderror
                </div>
            </div>
            <div class="row">
                <div class="form-group col-6">
                    <label for="main_img">Main img :</label>
                    <input type="file" accept="image/*" name="main_img" class="form-control">
                     @error("main_img")
                    <div class="alert alert-danger mt-1">
                        {{ $message }}
                    </div>
                 @enderror
                </div>
                <div class="form-group col-6">
                    <label for="more_imgs">More imgs:</label>
                    <input type="file" accept="image/*" multiple name="more_imgs[]" class="form-control">
                      @error("more_imgs")
                    <div class="alert alert-danger mt-1">
                        {{ $message }}
                    </div>
                 @enderror
                </div>
            </div>
            <div class="form-group ">
                <label for="description">Description:</label>
                <textarea name="description" class="form-control" id="description" cols="30" rows="6">
                      {{ old("description") }}
                </textarea>
                  @error("description")
                    <div class="alert alert-danger mt-1">
                        {{ $message }}
                    </div>
                 @enderror
            </div>

            <button type="submit" class="btn btn-primary mt-4" name="page" value="index" > Create </button>
            <button type="submit" class="btn btn-dark mt-4" name="page" value="create" > Create & return </button>

        </form>
    </div>


@endsection;



