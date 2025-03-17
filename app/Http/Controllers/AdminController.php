<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\category; 
use App\Models\product;

class AdminController extends Controller
{
    public function view_category()
    {
        $data = category::all();
        return view('admin.category',compact('data'));
    }
    public function add_category(Request $request)
    {
        $category = new category();
        $category->category_name = $request->category;
        $category->save();
        session()->flash('success', 'The category has been added successfully');
        return redirect()->back();
    }
    public function delete_category($id)
    {
        $data = category::find($id);
        $data->delete();
        session()->flash('success', 'The category has been deleted successfully');
        return redirect()->back();
    }

    public function edit_category($id)
    {
        $data = category::find($id);
        return view('admin.edit_category',compact('data'));
    }

    public function update_category(Request $request, $id)
    {
        $data = category::find($id);
        $data->category_name = $request->category;
        $data->save();
        session()->flash('success', 'The category has been updated successfully');
        return redirect('/view_category');
    }
    public function add_product()
    {
        $category = category::all();
        return view('admin.add_product',compact('category'));
    }

    public function upload_product(Request $request)
    {
        $data = new product();
        $data->title = $request->title;
        $data->description = $request->description;
        $data->price = $request->price;
        $data->quantity = $request->qty;
        $data->category = $request->category;
        
        $image = $request->image;
        if($image)
        {
            $request->validate([
                'image' => 'mimes:jpeg,jpg,png,gif|required|max:10000'
            ]);
            $data->image = $request->image->store('products','public');
            
        }

        $data->save();
        session()->flash('success', 'The product has been added successfully');
        return redirect()->back();
    }

    public function view_product()
    {
        $product = product::paginate(3);
        return view('admin.view_product',compact('product'));
    }
}
