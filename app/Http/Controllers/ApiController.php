<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Validator;
class ApiController extends Controller
{
     public function getAllProducts() {
      $products = Product::get()->toJson(JSON_PRETTY_PRINT);
      return response($products, 200);
    }

    public function createProduct(Request $request) {

    	
      $product = new Product;
      $product->pName = $request->pName;
      $product->pDesc = $request->pDesc;
      $product->pQuantity = $request->pQuantity;
      $product->pAmount = $request->pAmount;

      if(!$request->hasFile('fileName')) {
        return response()->json(['upload_file_not_found'], 400);
    }
 
    $allowedfileExtension=['pdf','jpg','png'];
    $file = $request->file('fileName'); 
 //print_r($request);exit;
 
        $extension = $file->getClientOriginalExtension();
 
        $check = in_array($extension,$allowedfileExtension);
 
        if($check) {
           // foreach($request->fileName as $mediaFiles) {
 
                //$path = $request->fileName->store('public/users');
              //$name = $request->fileName->getClientOriginalName();
      	
      	$uploadFolder = 'users';
	 $image = $request->file('fileName');
	 $image_uploaded_path = $image->store($uploadFolder, 'public');
 
                //store image file into directory and db
                // $save = new Image();
                // $save->title = $name;
                
           // }
        } else {
            return response()->json(['invalid_file_format'], 422);
        }
 
        
 
    

	   
$product->pImage = $image_uploaded_path;
                $product->save();
      return response()->json([
        "message" => "product record created"
      ], 201);
    }

    public function getProduct($id) {
      if (Product::where('id', $id)->exists()) {
        $product = Product::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
        return response($product, 200);
      } else {
        return response()->json([
          "message" => "Product not found"
        ], 404);
      }
    }

    public function updateProduct(Request $request, $id) {
      if (Product::where('id', $id)->exists()) {
        $product = Product::find($id);

        $product->pName = is_null($request->pName) ? $product->pName : $request->pName;
        $product->pDesc = is_null($request->pDesc) ? $product->pDesc : $request->pDesc;
        $product->pQuantity = is_null($request->pQuantity) ? $product->pQuantity : $request->pQuantity;
        $product->pAmount = is_null($request->pAmount) ? $product->pAmount : $request->pAmount;
        $product->pImage = is_null($request->pImage) ? $product->pImage : $request->pImage;
        $product->save();

        return response()->json([
          "message" => "records updated successfully"
        ], 200);
      } else {
        return response()->json([
          "message" => "Product not found"
        ], 404);
      }
    }

    public function deleteProduct ($id) {
      if(Product::where('id', $id)->exists()) {
        $product = Product::find($id);
        $product->delete();

        return response()->json([
          "message" => "records deleted"
        ], 202);
      } else {
        return response()->json([
          "message" => "Product not found"
        ], 404);
      }
    }
}
