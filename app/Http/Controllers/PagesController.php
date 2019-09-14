<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index()
    {
        $title = "Welcome to Laravel";
        // return view('pages.index', compact('title'));
        return view('pages.index')->with('title', $title);
    }

    public function about()
    {
        $title = "About Page";
        return view('pages.about')->with('title', $title);
    }

    public function services()
    {
        $data = array(
            'title' => 'Services',
            'services' => ['PHP-Laravel', 'Vue.js', 'xampp', 'Bootstrap']
        );
        return view('pages.services')->with($data);
    }
    // This was just for testing. I left it to show some progress I guess
}
