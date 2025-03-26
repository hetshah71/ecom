<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StaticPage;

class StaticPageController extends Controller
{
    public function show(string $slug=''){
        $page = StaticPage::where('slug', $slug)->first();
        return view('home.terms', compact('page'));
    }
}
