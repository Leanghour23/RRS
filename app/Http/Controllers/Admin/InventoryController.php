<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;

class InventoryController extends Controller
{
    public function index()
    {
        $rooms = Room::query()->withCount('bookingRequests')->orderBy('name')->get();

        return view('admin.inventory', [
            'inventoryStats' => [
                ['value' => $rooms->count(), 'label' => 'Total Rooms'],
                ['value' => $rooms->where('status', 'available')->count(), 'label' => 'Available'],
                ['value' => $rooms->where('status', 'occupied')->count(), 'label' => 'Occupied'],
                ['value' => $rooms->where('status', 'maintenance')->count(), 'label' => 'Maintenance'],
            ],
            'rooms' => $rooms,
            'alerts' => $rooms
                ->filter(fn (Room $room) => $room->status !== 'available' || $room->booking_requests_count === 0)
                ->take(3)
                ->values(),
        ]);
    }
}
