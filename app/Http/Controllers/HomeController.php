<?php

namespace App\Http\Controllers;

use App\Models\Room;

class HomeController extends Controller
{
    public function index()
    {
        return view('user.index', [
            'rooms' => Room::query()
                ->orderByDesc('is_featured')
                ->orderBy('name')
                ->get(),
        ]);
    }
}
