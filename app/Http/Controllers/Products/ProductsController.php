<?php
namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    public function index()
    {
        $products = DB::table("products")->select("*")->get();
        $categories = DB::table("categories")->select("*")->get();
        $allcategories=[];
        foreach($categories as $cat){
            $allcategories[$cat->cat_id]=$cat->name;
        }

        return view("AllProducts", compact("products","allcategories"));
    }

    public function create()
    {
        $Brands = DB::table("brands")->select("*")->get();
        $Categories = DB::table("categories")->select("*")->get();
        return view("CreateProduct", compact("Brands", "Categories"));
    }

    public function edit(Request $request, $id)

    {

        $Brands = DB::table("brands")->select("*")->get();
        $Categories = DB::table("categories")->select("*")->get();
        $productData=DB::table("products")->select("*")->where("id",$id)->first();
        $more_imgs=json_decode($productData->more_imgs,true);
        return view("EditProduct",compact("Brands" , "Categories","productData","more_imgs"));
    }

    public function store(Request $request)
    {
        // Validation rules
        $rules = [
            "name" => ["required", "string", "max:100"],
            "price" => ["required", "numeric", "min:1", "max:99999.99"],
            "quantity" => ["nullable", "integer", "min:1", "max:99999"],
            "category" => ["required", "integer"],
            "brand" => ["required", "integer"],
            "description" => ["required", "string"],
            "main_img" => ["required", "image", "max:1000", "mimes:png,jpg,jpeg"],
            "more_imgs.*" => ["nullable", "image", "mimes:png,jpg,jpeg", "max:4000"]
        ];
        $request->validate($rules);

        // Upload main image
        $mainImage = null;
        if ($request->hasFile('main_img')) {
            $mainImage = $this->storeImage($request->file('main_img'), 'main_img');
        }

        //  additional images
        $additionalImages = [];
        if ($request->hasFile('more_imgs')) {
            foreach ($request->file('more_imgs') as $image) {
                $path = $this->storeImage($image, 'more_imgs');
                $additionalImages[] = $path;
            }
        }

        // Save the product
        $data=[
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'quantity' => $request->input('quantity'),
            'category' => $request->input('category'),
            'brand_id' => $request->input('brand'),
            'description' => $request->input('description'),
            'main_img' => $mainImage,
            'more_imgs' => json_encode($additionalImages)
        ];
        DB::table('products')->insert($data);


        // Redirect
        if($request->page=="index"){
            return redirect()->route('product.index')->with('success', 'Product created successfully');
        }
        return redirect()->back()->with('success', 'Product created successfully');
    }

    public function delete(Request $request , $id)
    {

        $main_img=DB::table("products")->select("main_img")->where("id",$id)->first()->main_img;
        $more_imgs=DB::table("products")->select("more_imgs")->where("id",$id)->first()->more_imgs;
        $path_main_img=public_path("images/products/main_imgs/".$main_img);
        $arr_more_imgs= json_decode($more_imgs,true);


        if(file_exists($path_main_img)){
            unlink($path_main_img);
        }

        if(count($arr_more_imgs)>0){
            foreach ($arr_more_imgs as $img) {
                unlink(public_path("images/products/more_imgs/".$img));
            }
        }


        DB::table("products")->where("id","=",$id)->delete();
        return redirect()->back()->with('success', 'Product Deleted successfully');
    }

    public function update(Request $request,$id)
    {
        // Validation rules

        $rules = [
            "name" => ["required", "string", "max:100"],
            "price" => ["required", "numeric", "min:1", "max:99999.99"],
            "quantity" => ["nullable", "integer", "min:1", "max:99999"],
            "category" => ["required", "integer"],
            "brand" => ["required", "integer"],
            "description" => ["required", "string"],
            "main_img" => ["nullable", "image", "max:1000", "mimes:png,jpg,jpeg"],
            "more_imgs.*" => ["nullable", "image", "mimes:png,jpg,jpeg", "max:4000"]
        ];
        $request->validate($rules);
         $data=[
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'quantity' => $request->input('quantity'),
            'category' => $request->input('category'),
            'brand_id' => $request->input('brand'),
            'description' => $request->input('description')
        ];
        // upload imgs if exits

        if($request->has("main_img")) {

            $oldImg=DB::table("products")->select("main_img")->where("id",$id)->first();
            $oldPath=public_path("images/products/main_imgs/".$oldImg->main_img);
            if(file_exists($oldPath)){
                unlink($oldPath);
            }
            // upload new img
            $mainImage = $this->storeImage($request->file('main_img'), 'main_img');
            $data["main_img"]=$mainImage;
        }

        if($request->has("more_imgs")) {

            $alloldimgs=DB::table("products")->select("more_imgs")->where("id",$id)->first();
            $arroldImgs=json_decode( $alloldimgs->more_imgs,true);
            $arroldpaths=[];
            foreach($arroldImgs as $img) {
                $arroldpaths[]=public_path("images/products/more_imgs/".$img);
            }

            foreach($arroldpaths as $img) {
                if(file_exists($img)){
                unlink($img);
            }

            }


            // upload more imgs
            $additionalImages=[];
             foreach ($request->file('more_imgs') as $image) {
                $path = $this->storeImage($image, 'more_imgs');
                $additionalImages[] = $path;
            }
            $data["more_imgs"]=json_encode($additionalImages);
        }



        DB::table('products')->where('id', $id)->update($data);

         // Redirect
        if($request->page=="index"){
            return redirect()->route('product.index')->with('success', 'Product updated successfully');
        }
        return redirect()->back()->with('success', 'Product updated successfully');

    }


    public function getProducts() { 
        $products=DB::table("products")->get();
        foreach($products as $product){
            $product->more_imgs=json_decode($product->more_imgs);
        }
        return response()->json(["data"=>$products]);
    }
    private function storeImage($image, $prefix)
    {
        $filename = $prefix . '_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        if ($prefix == "main_img") {
            $image->move(public_path('images/products/main_imgs'), $filename);
            return $filename;
        } else {
            $image->move(public_path('images/products/more_imgs'), $filename);
            return  $filename;
        }
    }


}
