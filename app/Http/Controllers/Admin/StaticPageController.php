<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use App\Models\StaticPage;
use Illuminate\Support\Str;

class StaticPageController extends Controller
{
    public function index()
    {
        try {
            $pages = StaticPage::all();
            return view('admin.pages.index', compact('pages'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to retrieve static pages!');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            return view('admin.pages.create');
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

            $data = StaticPage::create([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'content' => $request->content,
                'status' => $request->status,
            ]);

            if ($data) {
                return redirect()->route('admin.pages.index')->with('success', 'Static Page created successfully');
            } else {
                return back()->with('error', 'Something went wrong, Please try again');
            }
        } catch (Exception $e) {
            return back()->with('error', 'Failed to create static Page!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        try {
            $page = StaticPage::where('slug', $slug)->first();
            return view('admin.pages.edit', compact('page'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Failed to retrieve static Page details!');
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

            StaticPage::where('slug', $slug)->first()->update([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'content' => $request->content,
                'status' => $request->status,
            ]);

            return redirect()->route('admin.pages.index')->with('success', 'Static Page updated successfully');
        } catch (Exception $e) {
            return back()->with('error', 'Failed to update static Page!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug)
    {
        try {
            StaticPage::where('slug', $slug)->first()->delete();
            return redirect()->route('admin.pages.index')->with('success', 'Static Page deleted successfully');
        } catch (Exception $e) {
            return back()->with('error', 'Failed to delete static Page!');
        }
    }
}
