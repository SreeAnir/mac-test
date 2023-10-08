<?php

namespace App\Http\Controllers;
use App\Http\Requests\ProductCreateRequest;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::paginate(10);  
        return view('product.index', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sizes = Size::all();
        $colors = Color::all();

        return view('product.create', compact('sizes', 'colors'));
    }

    public function store(ProductCreateRequest $request)
    {
       
    try {
        $validatedData = $request->validated();

        $product = new Product();
        $product->title = $validatedData['title'];
        $product->description = $validatedData['description'];
        $product->save();
        if( $product ){
            $product->sizes()->sync($validatedData['sizes']); 
            $product->colors()->sync($validatedData['colors']); 
            // Retrieve the ajxuploaded file name from the request
            $mainImageFileName = $request->input('main_image_file_name');
            
            $last_dot_position = strrpos($mainImageFileName, '.');
            $exxt = substr($mainImageFileName, $last_dot_position + 1);
            $newFileName = time() . '.' . $exxt;

            $file_moved= Storage::disk('public')->move('uploads/' . $mainImageFileName, 'uploads/products/' . $newFileName);
            
            if($file_moved){
                $product->main_image = $newFileName;  
                $product->save();
            }
        }

        return redirect()->route('products.index')->with('success', 'Product created successfully.');

    }catch (\Exception $e) {  
        dd($e); 
        return redirect()->back()->with('error', __('Failed to create Prod'));
    }
    }

 

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
      /**
     * Upload the file via ajax
     */
    public function upload(Request $request)
    {
    $request->validate([
        'file' => 'required|file|mimes:jpeg,png,jpg,gif|max:2048', // Adjust validation rules as needed
    ]);

    $uploadedFile = $request->file('file');
    $fileName = time() . '_' . $uploadedFile->getClientOriginalName();
    $uploadedFile->storeAs('uploads', $fileName, 'public');

    // Return the saved file name
    return response()->json(['file_name' => $fileName]);
    } 
}
