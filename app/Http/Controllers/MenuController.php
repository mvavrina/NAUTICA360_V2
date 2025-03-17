<?php

namespace App\Http\Controllers;

use Biostate\FilamentMenuBuilder\Models\MenuItem;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    //
    public function index()
    {
        $menuItems = MenuItem::whereNull('parent_id')->with('children', 'model')->get();
        return view('layouts.menu', compact('menuItems'));
    }
}
