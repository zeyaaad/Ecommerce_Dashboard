<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{

    public function index(){
        $categories = DB::table("categories")->select("*")->get();
        return view("AllCategories",compact("categories"));
    }

    public function create(){
        return view("CreateCategory");
    }

        public function store(Request $request)
        {
        // Validation rules
        $rules = [
            "name" => ["required", "string", "max:100"],
            "main_img" => ["required", "image", "max:1000", "mimes:png,jpg,jpeg"]
        ];
        $request->validate($rules);

        // Upload main image
        $mainImage = null;
        if ($request->hasFile('main_img')) {
            $mainImage = $this->storeImage($request->file('main_img'));
        }


        // Save the product
        $data=[
            'name' => $request->input('name'),
            'cat_img' => $mainImage
        ];

        DB::table('categories')->insert($data);


        // Redirect
        if($request->page=="index"){
            return redirect()->route('category.index')->with('success', 'Category created successfully');
        }
        return redirect()->back()->with('success', 'Category created successfully');
    }

    public function edit(Request $request, $id)
    {

        $categoryData=DB::table("categories")->select("*")->where("cat_id",$id)->first();
        return view("EditCategory",compact("categoryData"));
    }


        public function update(Request $request,$id)
    {
        // Validation rules

        $rules = [
            "name" => ["required", "string", "max:100"],
            "main_img" => ["nullable", "image", "max:1000", "mimes:png,jpg,jpeg"],
        ];
        $request->validate($rules);
         $data=[
            'name' => $request->input('name'),
        ];
        // upload imgs if exits

        if($request->has("main_img")) {

            $oldImg=DB::table("categories")->select("cat_img")->where("cat_id",$id)->first();
            $oldPath=public_path("images/categories/".$oldImg->cat_img);
            if(file_exists($oldPath)){
                unlink($oldPath);
            }
            // upload new img
            $mainImage = $this->storeImage($request->file('main_img'));
            $data["cat_img"]=$mainImage;
        }




        DB::table('categories')->where('cat_id', $id)->update($data);

         // Redirect
        if($request->page=="index"){
            return redirect()->route('category.index')->with('success', 'Category updated successfully');
        }
        return redirect()->back()->with('success', 'Category updated successfully');

    }





       public function delete(Request $request , $id)
    {

        $main_img=DB::table("categories")->select("cat_img")->where("cat_id",$id)->first()->cat_img;
        $path_main_img=public_path("images/categories/".$main_img);


        if(file_exists($path_main_img)){
            unlink($path_main_img);
        }



        DB::table("categories")->where("cat_id","=",$id)->delete();
        return redirect()->back()->with('success', 'Category Deleted successfully');
    }

 private function storeImage($image)
    {
        $filename =time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/categories/'), $filename);
            return $filename;

    }
}
