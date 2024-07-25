@extends('layouts.layout');

@section("title" , "Edit Product") ;

@section("content")


    <style>
        .productImg{
            border:1px solid white;
            box-shadow: 0px 0px 15px -10px black;
            border-radius: 10px;
        }
    </style>
    <div class="card w-100">
        @include("layouts.message")
        <form action="{{ route("product.update",$productData->id) }}" enctype="multipart/form-data" method="POST" class="p-3">
            @method("PUT")
            @csrf
            <div class="form-group">
                <label for="name">Product Name:</label>
                <input type="text" name="name" value="{{ $productData->name }}" class="form-control">
                 @error("name")
                 <div class="alert alert-danger mt-1">
                    {{ $message }}
                 </div>

                 @enderror
            </div>
            <div class="row">
                <div class="form-group col-6">
                    <label for="price">Price :</label>
                    <input value="{{ $productData->price }}" type="text" name="price" class="form-control">
                 @error("price")
                    <div class="alert alert-danger mt-1">
                        {{ $message }}
                    </div>
                 @enderror
                </div>
                <div class="form-group col-6">
                    <label for="quantity">Quantity  :</label>
                    <input value="{{ $productData->quantity }}" type="text" name="quantity" class="form-control">
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
                        <option {{ $productData->category== $cat->cat_id? "selected" :"" }} value="{{ $cat->cat_id }}">{{ $cat->name}}</option>
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
                        <option  {{ $productData->brand_id== $brand->brand_id?"selected" :"" }} value="{{ $brand->brand_id }}">{{ $brand->name}}</option>
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
                <div class="form-group col-lg-6 col-12">
                    <label for="main_img">Main img :</label>
                    <input type="file" accept="image/*" name="main_img" class="form-control">

                    <div class="cont_main_img text-center">
                        <img class="mt-3 ms-5 productImg" width="300" src="{{ url("images/products/main_imgs/".$productData->main_img) }}" alt="Product Img">

                    </div>

                     @error("main_img")
                    <div class="alert alert-danger mt-1">
                        {{ $message }}
                    </div>
                 @enderror
                </div>
                <div class="form-group col-lg-6 col-12">
                    <label for="more_imgs">More imgs:</label>
                    <input type="file" accept="image/*" multiple name="more_imgs[]" class="form-control">
                    <div class="cont_more_imgs text-center">
                        @foreach ($more_imgs as $imgs )
                            <img class="mt-3 ms-3 productImg"  width="200" src="{{ url("images/products/more_imgs/".$imgs) }}" alt="more_imgs">
                        @endforeach
                    </div>
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
                      {{  $productData->description}}
                </textarea>
                  @error("description")
                    <div class="alert alert-danger mt-1">
                        {{ $message }}
                    </div>
                 @enderror
            </div>

            <button type="submit" class="btn btn-primary mt-4" name="page" value="index" > Update </button>
            <button type="submit" class="btn btn-dark mt-4" name="page" value="create" > Update & return </button>

        </form>
    </div>


@endsection;


{{--

    id ->int
    name ->str
    price ->int
    Category->str
    Brand
    Quantity->number
    desc->string
    img->string
    moreimgs ->[]

    --}}
