<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookingRequest;
use App\Models\CustomerProfile;
use App\Models\Room;

class DashboardController extends Controller
{
    public function index()
    {
        $bookingCount = BookingRequest::query()->count();
        $customerCount = CustomerProfile::query()->count();
        $roomCount = Room::query()->count();
        $revenue = BookingRequest::query()->sum('total_amount');

        return view('admin.dashboard', [
            'metrics' => [
                ['value' => $customerCount, 'label' => 'Customers', 'accent' => 'light'],
                ['value' => $roomCount, 'label' => 'Rooms', 'accent' => 'light'],
                ['value' => $bookingCount, 'label' => 'Bookings', 'accent' => 'light'],
                ['value' => '$' . number_format((float) $revenue, 0), 'label' => 'Expected Revenue', 'accent' => 'strong'],
            ],
            'bookings' => BookingRequest::query()
                ->with('room')
                ->latest()
                ->limit(8)
                ->get(),
            'customers' => CustomerProfile::query()
                ->with('user')
                ->latest()
                ->limit(6)
                ->get(),
        ]);
    }
}
