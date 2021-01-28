<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Validator;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
		$image = $request->fileName;  // your base64 encoded
		$image = str_replace('data:image/png;base64,', '', $image);
		$image = str_replace(' ', '+', $image);
		$imageName = Str::random(10).'.'.'png';
		Storage::disk('local')->put($imageName, base64_decode($image));
		$product->pImage = $imageName;
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
