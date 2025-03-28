<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Exception;

class ProductController extends Controller
{
    public function add_product()
    {
        try {
            $category = Category::all();
            return view('admin.add_product', compact('category'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    public function upload_product(StoreProductRequest $request)
    {
        try {
            $request->validated();

            $data = new product();
            $data->title = $request->title;
            $data->description = $request->description;
            $data->price = $request->price;
            $data->quantity = $request->qty;
            $data->category = $request->category;
            $data->slug = Str::slug($request->title);

            if ($request->hasFile('image')) {
                $request->validate([
                    'image' => 'mimes:jpeg,jpg,png,gif|required|max:10000'
                ]);
                $data->image = $request->image->store('products', 'public');
            }

            $data->save();
            session()->flash('success', 'The product has been added successfully');
            return redirect('/admin/view_product');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to add product!');
        }
    }

    public function view_product()
    {
        try {
            $products = product::paginate(3);
            return view('admin.view_product', compact('products'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to retrieve products!');
        }
    }

    public function delete_product($id)
    {
        try {
            $data = product::findOrFail($id);
            $data->delete();
            session()->flash('success', 'The product has been deleted successfully');
            return redirect()->back();
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete product!');
        }
    }

    public function edit_product($id)
    {
        try {
            $product = product::findOrFail($id);
            $category = Category::all();
            return view('admin.edit_product', compact('product', 'category'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to retrieve product details!');
        }
    }

    public function update_product(StoreProductRequest $request, $id)
    {
        try {
            $data = product::findOrFail($id);
            $request->validated();

            $data->title = $request->title;
            $data->description = $request->description;
            $data->price = $request->price;
            $data->quantity = $request->qty;
            $data->category = $request->category;

            if ($request->hasFile('image')) {
                $request->validate([
                    'image' => 'mimes:jpeg,jpg,png,gif|required|max:10000'
                ]);
                if ($data->image) {
                    Storage::disk('public')->delete($data->image);
                }
                $data->image = $request->image->store('products', 'public');
            }

            $data->save();
            session()->flash('success', 'The product has been updated successfully');
            return redirect('/admin/view_product');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to update product!');
        }
    }

    public function deleted_products()
    {
        try {
            $product = product::onlyTrashed()->paginate(3);
            return view('admin.deleted_products', compact('product'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to retrieve deleted products!');
        }
    }

    public function restore_product($id)
    {
        try {
            $data = product::withTrashed()->findOrFail($id);
            $data->restore();
            session()->flash('success', 'The product has been restored successfully');
            return redirect()->back();
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to restore product!');
        }
    }
    public function force_delete_product($id)
    {
        try {
            $data = product::withTrashed()->find($id);
            if ($data) {
                $data->forceDelete();
                session()->flash('success', 'The product has been permanently deleted successfully');
                return redirect()->back();
            } else {
                session()->flash('error', 'product not found.');
            }
        } catch (Exception $e) {
            session()->flash('error', 'Failed to permanently delete product: ' . $e->getMessage());
        }
    }

}
