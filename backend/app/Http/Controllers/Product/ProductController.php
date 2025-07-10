<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Application\Product\RegisterProduct;
use App\Models\Archive;
use App\Models\Products;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function __construct(private RegisterProduct $registerProduct)
    {
        return $this->registerProduct = $registerProduct;
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string',
            'category' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'description' => 'required|string',
            'image' => 'required|nullable'
        ]);

        if($validator->fails())
        {
            return redirect()->route('dashboard')->with('error' , $validator->errors());
        }

        $data = [];

         if($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $data['image'] = $filename;
        }

        do{
            $product_id = random_int(111111,666666);
        }while(Products::where('product_id' , $product_id)->exists());


        $this->registerProduct->create(
            $product_id,
            $request->name,
            $request->category,
            $request->price,
            $request->stock,
            $request->description,
           $data['image']
        );

        return redirect()->route('dashboard')->with('success', 'Product Created Successfully');
    }

    public function archive($id)
    {
        $product = Products::find($id);

        if(!$product) {
            return redirect()->route('dashboard')->with('error', 'Product not found');
        }

        $product->delete();

        Archive::create([
            'product_id' => $product->product_id,
            'name' => $product->name,
            'price' => $product->price,
            'stock' => $product->stock,
            'description' => $product->description,
            'image' => $product->image
        ]);

        return redirect()->route('dashboard')->with('success', 'Product archived successfully');
    }

    public function restore($id)
    {
        $product = Archive::find($id);

        if(!$product) {
            return redirect()->route('archive')->with('error', 'Product not found');
        }

        $product->delete();

       
        // $this->registerProduct->create(
        //     $product->product_id,
        //     $product->name,
        //     $product->price,
        //     $product->stock,
        //     $product->description,
        //     $product->image
        // );
       
        Products::create([
            'product_id' => $product->product_id,
            'name' => $product->name,
            'price' => $product->price,
            'stock' => $product->stock,
            'description' => $product->description,
            'image' => $product->image
        ]);

        return redirect()->route('archive')->with('success', 'Product archived successfully');
    }

    public function delete(int $id)
    {
        $product = Archive::find($id);

        if(!$product) {
            return redirect()->route('archive')->with('error', 'Product not found');
        }

        $product->delete();
        // $this->registerProduct->delete($product);

        return redirect()->route('archive')->with('success', 'Product deleted successfully');
    }

    public function update(Request $request, $id)
    {
        $product = Products::find($id);

        if(!$product) {
            return redirect()->route('dashboard')->with('error', 'Product not found');
        }

        Validator::make(request()->all(), [
            'name' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'description' => 'required|string',
            'image' => 'nullable|image'
        ])->validate();

       $data = [];

         if($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $data['image'] = $filename;
        }


        $this->registerProduct->update(
            $product->product_id,
            $request->name,
            $request->category,
            $request->price,
            $request->stock,
            $request->description,
            $data['image'] ?? $product->image
        );

        return redirect()->route('dashboard')->with('success', 'Product updated successfully');
    }
}
