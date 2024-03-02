<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function create()
    {
        return view('item.create');
    }

    public function edit(Item $item)
    {
        return view('item.create', compact('item'));
    }

    public function store(Request $request)
    {
        dd($request->file());
    }
}
