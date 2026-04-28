<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Response;

class RoomController extends Controller
{
    public function show(string $room): Response
    {
        $roomData = Room::query()
            ->with(['amenities', 'policies'])
            ->where('slug', $room)
            ->firstOrFail();

        return response()->view('user.show', [
            'room' => $roomData,
        ]);
    }
}
