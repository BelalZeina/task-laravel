<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\Product;
use App\Models\ProductAttributeValue;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $data = Product::where("owner_type",get_class(Admin::first()))->where("price_after_discount",0)->latest()->get();
        return view("dashboard.products.index", compact("data"));
    }


    public function create()
    {
        $categories = CategoryProduct::all();

        return view("dashboard.products.create",compact('categories'));

    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'stock' => 'required|integer',
            'price' => 'required|numeric',
            'category_id' => 'nullable|array',
            'category_id.*' => 'exists:category_products,id',
            'attributes' => 'nullable|array',
            'attributes.*.type' => 'required|in:text,color',
            'attributes.*.name' => 'required|string',
            'attributes.*.value' => 'nullable|string',
            'attributes.*.color' => 'nullable|string',
            'attributes.*.price' => 'nullable|numeric',
            'images' => 'nullable|array',
            'images.*' => 'nullable|string',
            'img' => 'required|file|mimes:jpg,png,jpeg'
        ]);

        // Store the main product data
        $data=$request->only('name', 'description', 'stock', 'price');
        $data['owner_id'] = auth("admin")->id();
        $data['owner_type'] = get_class(auth("admin")->user());
        if ($request->hasFile('img')) {
            $data['img'] = UploadImage($request->file('img'), "images");
        }
        $product = Product::create($data);

        // Attach categories
        if ($request->has('category_id')) {
            $product->categories()->attach($request->input('category_id'));
        }

    // Handle attributes and attribute values
    if ($request->has('attributes')) {
        foreach ($request->input('attributes') as $attributeData) {
            // Find or create the attribute
            $attribute = Attribute::firstOrCreate([
                'name' => $attributeData['name'],
                'product_id' => $product->id,
            ]);

            // Create the product attribute value
            ProductAttributeValue::create([
                'attribute_id' => $attribute->id,
                'value' => $attributeData['type'] === 'text' ? $attributeData['value'] : null,
                'color' => $attributeData['type'] === 'color' ? $attributeData['color'] : null,
                'price' => $attributeData['price'],
            ]);
        }
    }

        // Handle image URLs if necessary
        if ($request->images) {
            $filteredImages = array_filter($request->images);
            $product->update(['images' => json_encode($filteredImages)]) ;
        }

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }


    public function dropzone(Request $request)
    {
        if ($request->file('file')) {
            $image = uploadImage($request->file,"products");
            $path = $image;
            return $path;
        }
    }


    public function show($id)
    {
        $data = Product::find($id);
        return view("dashboard.products.show", compact("data"));
    }


    public function edit($id)
    {
        $categories = CategoryProduct::all();
        $data = Product::find($id);
        return view("dashboard.products.edit", compact("data",'categories'));
    }


    public function update(Request $request, $id)
    {
        // return $request->all();
        $request->validate([
            'name' => 'required',
            'stock' => 'required',
            'price' => 'required',
            'description' => 'nullable',
            'img' => 'nullable|image',
            'attributes' => 'nullable|array',
            'attributes.*.type' => 'required|in:text,color',
            'attributes.*.name' => 'required|string',
            'attributes.*.value' => 'nullable|string',
            'attributes.*.color' => 'nullable|string',
            'attributes.*.price' => 'nullable|numeric',
            'images' => 'nullable|array',
            'category_id' => 'required|array',
        ]);

        $data = $request->except( 'img','images');

        if ($request->hasFile('img')) {
            $data['img'] = UploadImage($request->file('img'), "images");
        }
        if ($request->images) {
            $filteredImages = array_filter($request->images);
            $data['images'] = json_encode($filteredImages);
        }

        $data['owner_id'] = auth("admin")->id();
        $data['owner_type'] = get_class(auth("admin")->user());

        $product = Product::find($id);
        $product->update($data);
        // Handle attributes and attribute values
        $product->attributeValues()->delete();
        if ($request->has('attributes')) {
            foreach ($request->input('attributes') as $attributeData) {
                // Find or create the attribute
                $attribute = Attribute::firstOrCreate([
                    'name' => $attributeData['name'],
                    'product_id' => $product->id,
                ]);

                // Create the product attribute value
                ProductAttributeValue::create([
                    'attribute_id' => $attribute->id,
                    'value' => $attributeData['type'] === 'text' ? $attributeData['value'] : null,
                    'color' => $attributeData['type'] === 'color' ? $attributeData['color'] : null,
                    'price' => $attributeData['price'],
                ]);
            }
        }
        if ($request->category_id) {
            $categoryIds = $request->category_id;
            $product->categories()->attach($categoryIds);
        }
        return redirect(route('products.index'))->with('success', __('models.edited_successfully'));
    }


    public function destroy($id)
    {
        $model = Product::find($id);
        $model->delete();
        return redirect(route('products.index'))->with('success', __('models.deleted_successfully'));

    }

    public function deleteSelected(Request $request)
    {
        $ids = $request->ids;
        foreach ($ids as $id) {
            $model = Product::find($id);
            if ($model) {
                $model->delete();
            }
        }
        return response()->json(['success' => true]);
    }
    public function toggleActivation(Request $request)
    {
        $model = Product::findOrFail($request->id);
        $model->is_active = !$model->is_active;
        $model->save();

        return response()->json(['success' => true, 'is_active' => $model->is_active]);
    }

}
