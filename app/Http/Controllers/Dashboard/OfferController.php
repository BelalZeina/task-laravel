<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\Product;
use App\Models\ProductAttributeValue;
use Illuminate\Http\Request;

class OfferController extends Controller
{

    public function index(Request $request)
    {
        $data = Product::where("owner_id",auth("admin")->id())->where("owner_type",get_class(Admin::first()))->where("price_after_discount","!=",0)->latest()->get();
        return view("dashboard.offer.index", compact("data"));
    }


    public function create()
    {
        $categories = CategoryProduct::all();

        return view("dashboard.offer.create",compact('categories'));

    }

    public function offer_on_product()
    {
        $products = Product::where("owner_type",get_class(auth("admin")->user()))->where("price_after_discount",0)->get();

        return view("dashboard.offer.products",compact('products'));

    }

    public function store_offer_on_product (Request $request)
    {
        $request->validate([

            'product_id' => 'required|array',
            'discount_percentage' => 'nullable|integer|min:0|max:100',
            'fixed_discount' => 'nullable|numeric|min:0',
        ]);
        if($request->product_id){
            $products=Product::whereIn("id",$request->product_id)->get();
        }
        // if($request->category){
        //     $category = Category::query()->findOrFail($request->input('category'));
        //     $products = $category->products()->where("country",Storage::get("user_country"))->active()->get();
        // }
        foreach($products as $product){
            if ($request->discount_type === 'fixed') {
                $priceAfterDiscount = $product->price - $request->fixed_discount;
                $fixed=$request->fixed_discount;
                $percentage=null;
            } else if ($request->discount_type === 'percentage') {
                $priceAfterDiscount = $product->price - ($product->price * ($request->discount_percentage / 100));
                $fixed=null;
                $percentage= $request->discount_percentage;
            }
            $product->update([
                "price_after_discount"=> $priceAfterDiscount,
                "fixed_discount"=> $fixed,
                "discount_percentage"=> $percentage,
            ]);
        }
        return redirect()->route('offers.index')->with('success', __('models.added_successfully'));

    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'stock' => 'required',
            'price' => 'required',
            'description' => 'nullable',
            'img' => 'required|image',
            'images' => 'nullable|array',
            'category_id' => 'required|array',
            'discount_percentage' => 'nullable|integer|min:0|max:100',
            'fixed_discount' => 'nullable|numeric|min:0',
            'price_after_discount' => 'nullable|numeric|min:0',
            'attributes' => 'nullable|array',
            'attributes.*.type' => 'required|in:text,color',
            'attributes.*.name' => 'required|string',
            'attributes.*.value' => 'nullable|string',
            'attributes.*.color' => 'nullable|string',
            'attributes.*.price' => 'nullable|numeric',
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

        $product = Product::create($data);
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
        if ($request->category_id) {
            $categoryIds = $request->category_id;
            $product->categories()->attach($categoryIds);
        }

        return redirect(route('offers.index'))->with('success', __('models.added_successfully'));
    }

    public function dropzone(Request $request)
    {
        if ($request->file('file')) {
            $image = uploadImage($request->file,"offer");
            $path = $image;
            return $path;
        }
    }


    public function show($id)
    {
        $data = Product::find($id);
        return view("dashboard.offer.show", compact("data"));
    }


    public function edit($id)
    {
        $categories = CategoryProduct::all();
        $data = Product::find($id);
        return view("dashboard.offer.edit", compact("data",'categories'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'stock' => 'required',
            'price' => 'required',
            'description' => 'nullable',
            'img' => 'nullable|image',
            'images' => 'nullable|array',
            'category_id' => 'required|array',
            'discount_percentage' => 'nullable|integer|min:0|max:100',
            'fixed_discount' => 'nullable|numeric|min:0',
            'price_after_discount' => 'nullable|numeric|min:0',
            'attributes' => 'nullable|array',
            'attributes.*.type' => 'required|in:text,color',
            'attributes.*.name' => 'required|string',
            'attributes.*.value' => 'nullable|string',
            'attributes.*.color' => 'nullable|string',
            'attributes.*.price' => 'nullable|numeric',
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
        return redirect(route('offers.index'))->with('success', __('models.edited_successfully'));
    }


    public function destroy($id)
    {
        $model = Product::find($id);
        $model->update([
            "price_after_discount"=> 0,
            "fixed_discount"=> null,
            "discount_percentage"=> null,
        ]);
        return redirect(route('offers.index'))->with('success', __('models.deleted_successfully'));

    }

    public function deleteSelected(Request $request)
    {
        $ids = $request->ids;
        foreach ($ids as $id) {
            $model = Product::find($id);
            if ($model) {
                $model->update([
                    "price_after_discount"=> 0,
                    "fixed_discount"=> null,
                    "discount_percentage"=> null,
                ]);
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
