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
    //$imageName =str_random(10).'.'.'png';
	$imageName = Str::random(10).'.'.'png';
    Storage::disk('local')->put($imageName, base64_decode($image));
	
    // $response = array(
        // 'status' => 'success',
    // );
    // return Response::json( $response  );
	
	
      // if(!$request->hasFile('fileName')) {
        // return response()->json(['upload_file_not_found'], 400);
    // }
	//$path = $this->createImage($request->fileName);
    // $allowedfileExtension=['pdf','jpg','png'];
    // $file = $request->file('fileName'); 
	// $extension = $file->getClientOriginalExtension();
	// $check = in_array($extension,$allowedfileExtension);
	// if($check) {
      	// $uploadFolder = 'users';
		// $image = $request->file('fileName');
		// $image_uploaded_path = $image->store($uploadFolder, 'public');
        // }
		// else {
            // return response()->json(['invalid_file_format'], 422);
        // }

		$product->pImage = $imageName;
        $product->save();
		  return response()->json([
			"message" => "product record created"
		  ], 201);
    }
	
	
	 public function createImage($img)
    {
	
		
		// $folderPath = "users";

		// $image_parts = explode(";base64,", $img);
		// $image_type_aux = explode("image/", $image_parts[0]);
		// $image_type = $image_type_aux[1];
		// $image_base64 = base64_decode($image_parts[1]);
		// $file = $folderPath . uniqid() . '. '.$image_type;

		// file_put_contents($file, $image_base64);
		// return $file;
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
