<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StaticPage;

class StaticPageController extends Controller
{
    public function show(string $slug='terms'){
        $page = StaticPage::where('slug', $slug)->where('status',1)->first();
        if(!$page){
            abort(404);
        }
        return view('home.terms', compact('page'));
    }
}
