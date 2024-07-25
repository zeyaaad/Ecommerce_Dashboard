<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BrandController extends Controller
{
    public function index(){
        $brands = DB::table("brands")->select("*")->get();
        return view("AllBrands",compact("brands"));
    }

    public function create(){
        return view("CreateBrand");
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
            'brand_img' => $mainImage
        ];

        DB::table('brands')->insert($data);


        // Redirect
        if($request->page=="index"){
            return redirect()->route('brand.index')->with('success', 'Brand created successfully');
        }
        return redirect()->back()->with('success', 'Brand created successfully');
    }

    public function edit(Request $request, $id)
    {

        $brandData=DB::table("brands")->select("*")->where("brand_id",$id)->first();
        return view("EditBrand",compact("brandData"));
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

            $oldImg=DB::table("brands")->select("brand_img")->where("brand_id",$id)->first();
            $oldPath=public_path("images/brands/".$oldImg->brand_img);
            if(file_exists($oldPath)){
                unlink($oldPath);
            }
            // upload new img
            $mainImage = $this->storeImage($request->file('main_img'));
            $data["brand_img"]=$mainImage;
        }




        DB::table('brands')->where('brand_id', $id)->update($data);

         // Redirect
        if($request->page=="index"){
            return redirect()->route('brand.index')->with('success', 'Brand updated successfully');
        }
        return redirect()->back()->with('success', 'Brand updated successfully');

    }





       public function delete(Request $request , $id)
    {

        $main_img=DB::table("brands")->select("brand_img")->where("brand_id",$id)->first()->brand_img;
        $path_main_img=public_path("images/brands/".$main_img);


        if(file_exists($path_main_img)){
            unlink($path_main_img);
        }



        DB::table("brands")->where("brand_id","=",$id)->delete();
        return redirect()->back()->with('success', 'Brand Deleted successfully');
    }

 private function storeImage($image)
    {
        $filename =time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/brands/'), $filename);
            return $filename;

    }
}

