<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookingRequest;

class BookingController extends Controller
{
    public function index()
    {
        $query = BookingRequest::query()->with(['room', 'user'])->latest();

        return view('admin.booking', [
            'bookingStats' => [
                ['value' => BookingRequest::query()->count(), 'label' => 'All Requests'],
                ['value' => BookingRequest::query()->where('status', 'pending')->count(), 'label' => 'Pending Approval'],
                ['value' => BookingRequest::query()->where('status', 'confirmed')->count(), 'label' => 'Confirmed Stays'],
                ['value' => '$' . number_format((float) BookingRequest::query()->sum('total_amount'), 0), 'label' => 'Expected Revenue'],
            ],
            'bookings' => $query->get(),
        ]);
    }
}
