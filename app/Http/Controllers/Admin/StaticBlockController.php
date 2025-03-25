<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StaticBlock;
use Illuminate\Support\Str;
use Exception;

class StaticBlockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $blocks = StaticBlock::all();
            return view('admin.blocks.index', compact('blocks'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to retrieve static blocks!');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            return view('admin.blocks.create');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required',
                'content' => 'required',
                'status' => 'required',
            ]);

            $data = StaticBlock::create([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'content' => $request->content,
                'status' => $request->status,
            ]);

            if ($data) {
                return redirect()->route('admin.blocks.index')->with('success', 'Static block created successfully');
            } else {
                return back()->with('error', 'Something went wrong, Please try again');
            }
        } catch (Exception $e) {
            return back()->with('error', 'Failed to create static block!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        try {
            $block = StaticBlock::where('slug', $slug)->first();
            return view('admin.blocks.edit', compact('block'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to retrieve static block details!');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $slug)
    {
        try {
            $request->validate([
                'title' => 'required',
                'content' => 'required',
                'status' => 'required',
            ]);

            StaticBlock::where('slug', $slug)->first()->update([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'content' => $request->content,
                'status' => $request->status,
            ]);

            return redirect()->route('admin.blocks.index')->with('success', 'Static block updated successfully');
        } catch (Exception $e) {
            return back()->with('error', 'Failed to update static block!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug)
    {
        try {
            StaticBlock::where('slug', $slug)->first()->delete();
            return redirect()->route('admin.blocks.index')->with('success', 'Static block deleted successfully');
        } catch (Exception $e) {
            return back()->with('error', 'Failed to delete static block!');
        }
    }
}
