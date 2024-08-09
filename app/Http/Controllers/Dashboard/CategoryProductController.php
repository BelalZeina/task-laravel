<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryProduct;
use Illuminate\Http\Request;

class CategoryProductController extends Controller
{

    public function index(Request $request)
    {
        $data = CategoryProduct::get();
        return view("dashboard.category_product.index", compact("data"));
    }


    public function create()
    {
        return view("dashboard.category_product.create");

    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'desc' => 'nullable',
            'image' => 'nullable|image',
        ]);
        $data = $request->except( 'image');


        if ($request->hasFile('image')) {
            $data['image'] = UploadImage($request->file('image'), "images");
        }

        $admin = CategoryProduct::create($data);

        return redirect(route('category_products.index'))->with('success', __('models.added_successfully'));
    }


    public function show($id)
    {
        $data = CategoryProduct::find($id);
        return view("dashboard.category_product.show", compact("data"));
    }


    public function edit($id)
    {
        $data = CategoryProduct::find($id);
        return view("dashboard.category_product.edit", compact("data"));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'desc' => 'nullable',
            'image' => 'nullable|image',
        ]);
        $admin = CategoryProduct::find($id);
        $data = $request->except( 'image');

        if ($request->hasFile('image')) {
            $data['image'] = UploadImage($request->file('image'), "images");
        }
        $admin->update($data);
        return redirect(route('category_products.index'))->with('success', __('models.edited_successfully'));
    }


    public function destroy($id)
    {
        $admin = CategoryProduct::find($id);
        $admin->delete();
        return redirect(route('category_products.index'))->with('success', __('models.deleted_successfully'));

    }

    public function deleteSelected(Request $request)
    {
        $ids = $request->ids;
        // return response()->json(['success' => true ,"ids"=> $ids]);
        foreach ($ids as $id) {
            $admin = CategoryProduct::find($id);
            if ($admin) {
                $admin->delete();
            }
        }
        return response()->json(['success' => true]);
    }
    public function toggleActivation(Request $request)
    {
        $admin = CategoryProduct::findOrFail($request->id);
        $admin->is_active = !$admin->is_active;
        $admin->save();

        return response()->json(['success' => true, 'is_active' => $admin->is_active]);
    }

}
