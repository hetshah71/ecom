<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use Exception;

class CategoryController extends Controller
{
    public function view_category()
    {
        try {
            $data = Category::all();
            return view('admin.category', compact('data'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to fetch categories: ' . $e->getMessage());
        }
    }

    public function add_category(StoreCategoryRequest $request)
    {
        try {
            $category = new Category();
            $category->category_name = $request->category;
            $request->validated();
            $category->save();

            session()->flash('success', 'The category has been added successfully');
        } catch (Exception $e) {
            session()->flash('error', 'Failed to add category: ' . $e->getMessage());
        }

        return redirect()->back();
    }

    public function delete_category($id)
    {
        try {
            $data = Category::find($id);
            if ($data) {
                $data->delete();
                session()->flash('success', 'The category has been deleted successfully');
            } else {
                session()->flash('error', 'Category not found.');
            }
        } catch (Exception $e) {
            session()->flash('error', 'Failed to delete category: ' . $e->getMessage());
        }

        return redirect()->back();
    }

    public function edit_category($id)
    {
        try {
            $data = Category::find($id);
            if (!$data) {
                return redirect()->back()->with('error', 'Category not found.');
            }
            return view('admin.edit_category', compact('data'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to fetch category: ' . $e->getMessage());
        }
    }

    public function update_category(Request $request, $id)
    {
        try {
            $data = Category::find($id);
            if (!$data) {
                return redirect()->back()->with('error', 'Category not found.');
            }

            $data->category_name = $request->category;
            $data->save();

            session()->flash('success', 'The category has been updated successfully');
        } catch (Exception $e) {
            session()->flash('error', 'Failed to update category: ' . $e->getMessage());
        }

        return redirect('/admin/view_category');
    }
}
