@extends('layouts.layout');

@section("title" , "Edit Brand") ;

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
        <form action="{{ route("brand.update",$brandData->brand_id) }}" enctype="multipart/form-data" method="POST" class="p-3">
            @method("PUT")
            @csrf
            <div class="form-group">
                <label for="name">Brand Name:</label>
                <input type="text" name="name" value="{{ $brandData->name }}" class="form-control">
                 @error("name")
                 <div class="alert alert-danger mt-1">
                    {{ $message }}
                 </div>

                 @enderror
            </div>
            <div class="row">
                <div class="form-group  col-12">
                    <label for="main_img">Main img :</label>
                    <input type="file" accept="image/*" name="main_img" class="form-control">

                    <div class="cont_main_img text-center">
                        <img class="mt-3 ms-5 productImg" width="300" src="{{ url("images/brands/".$brandData->brand_img) }}" alt="Product Img">

                    </div>

                     @error("main_img")
                    <div class="alert alert-danger mt-1">
                        {{ $message }}
                    </div>
                 @enderror
                </div>

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
