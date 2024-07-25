@extends('layouts.layout');

@section("title" , "Create Category") ;

@section("content")

    <div class="card w-100">
        @include("layouts.message")

        <form action="{{ route("category.store") }}" enctype="multipart/form-data" method="POST" class="p-3">
            @csrf
            <div class="form-group">
                <label for="name">Category Name:</label>
                <input type="text" name="name" value="{{ old("name") }}" class="form-control">
                 @error("name")
                 <div class="alert alert-danger mt-1">
                    {{ $message }}
                 </div>

                 @enderror
            </div>

            <div class="row">
                <div class="form-group col-12">
                    <label for="main_img">Category img :</label>
                    <input type="file" accept="image/*" name="main_img" class="form-control">
                     @error("main_img")
                    <div class="alert alert-danger mt-1">
                        {{ $message }}
                    </div>
                 @enderror
                </div>
            </div>


            <button type="submit" class="btn btn-primary mt-4" name="page" value="index" > Create </button>
            <button type="submit" class="btn btn-dark mt-4" name="page" value="create" > Create & return </button>

        </form>
    </div>


@endsection;



