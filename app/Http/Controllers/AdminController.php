<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Order;
use App\Models\product;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;



class AdminController extends Controller
{
    public function view_category()
    {
        $data = Category::all();
        return view('admin.category', compact('data'));
    }
    public function add_category(Request $request)
    {
        $category = new Category();
        $category->category_name = $request->category;
        $category->save();
        session()->flash('success', 'The category has been added successfully');
        return redirect()->back();
    }
    public function delete_category($id)
    {
        $data = Category::find($id);
        $data->delete();
        session()->flash('success', 'The category has been deleted successfully');
        return redirect()->back();
    }

    public function edit_category($id)
    {
        $data = Category::find($id);
        return view('admin.edit_category', compact('data'));
    }

    public function update_category(Request $request, $id)
    {
        $data = Category::find($id);
        $data->category_name = $request->category;
        $data->save();
        session()->flash('success', 'The category has been updated successfully');
        return redirect('/admin/view_category');
    }
    public function add_product()
    {
        $category = Category::all();
        return view('admin.add_product', compact('category'));
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
        if ($image) {
            $request->validate([
                'image' => 'mimes:jpeg,jpg,png,gif|required|max:10000'
            ]);
            $data->image = $request->image->store('products', 'public');
        }

        $data->save();
        session()->flash('success', 'The product has been added successfully');
        return redirect('/admin/view_product');
    }

    public function view_product()
    {
        $product = product::paginate(3);
        return view('admin.view_product', compact('product'));
    }
    public function delete_product($id)
    {
        $data = product::find($id);
        if ($data->image) {
            Storage::disk('public')->delete($data->image);
        }
        $data->delete();
        session()->flash('success', 'The product has been deleted successfully');
        return redirect()->back();
    }

    public function edit_product($id)
    {
        $product = product::find($id);
        $category = Category::all();
        return view('admin.edit_product', compact('product', 'category'));
    }

    public function update_product(Request $request, $id)
    {
        $data = product::find($id);
        $data->title = $request->title;
        $data->description = $request->description;
        $data->price = $request->price;
        $data->quantity = $request->qty;
        $data->category = $request->category;

        $image = $request->image;
        if ($image) {
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
        return redirect('/view_product');
    }
    public function view_order() {
        $data = Order::all();
        return view('admin.order', compact('data'));
    }

    public function on_the_way($id){
        $data = Order::find($id);
        $data->status = 'On the way';
        $data->save();
        return redirect('/admin/view_orders');
    }
    public function delivered($id)
    {
        $data = Order::find($id);
        $data->status = 'Delivered';
        $data->save();
        return redirect('/admin/view_orders');
    }
    public function print_pdf($id){
        $data = Order::find($id);
        $pdf = Pdf::loadView('admin.invoice', compact('data'));
        return $pdf->download('invoice.pdf');

    }
}
