<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookingRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

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

    public function accept(BookingRequest $booking): RedirectResponse
    {
        if ($booking->status !== 'confirmed') {
            $booking->update([
                'status' => 'confirmed',
            ]);
        }

        return back()->with('status', 'Booking request ' . $booking->code . ' has been accepted.');
    }

    public function reject(BookingRequest $booking): RedirectResponse
    {
        $message = 'Booking request ' . $booking->code . ' was deleted.';

        DB::transaction(function () use ($booking, &$message) {
            $booking->loadMissing('user');

            if (! $booking->user) {
                $booking->delete();

                return;
            }

            if ($booking->user->is_admin || $booking->user->role === 'admin') {
                $booking->delete();
                $message = 'Booking request ' . $booking->code . ' was deleted. Admin accounts are not deleted.';

                return;
            }

            $deletedName = $booking->user->name;

            $booking->user->delete();

            $booking->delete();

            $message = 'Booking request ' . $booking->code . ' and user ' . $deletedName . ' were deleted.';
        });

        return back()->with('status', $message);
    }
}
