<?php

namespace App\Http\Controllers;

use App\Models\BookingRequest;
use App\Models\CustomerProfile;
use App\Models\Room;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BookingRequestController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $user = Auth::user();

        if ($user?->isAdmin()) {
            return back()->withErrors([
                'booking' => 'Admin accounts can view room details only and cannot submit booking requests.',
            ]);
        }

        $validated = $request->validate([
            'room_slug' => ['required', 'string', 'exists:rooms,slug'],
            'guest_name' => ['required', 'string', 'max:255'],
            'guest_email' => ['required', 'email', 'max:255'],
            'guest_phone' => ['nullable', 'string', 'max:50'],
            'move_in_date' => ['nullable', 'date'],
            'duration_value' => ['nullable', 'integer', 'min:1'],
            'duration_unit' => ['nullable', 'in:days,weeks,months'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $room = Room::query()->where('slug', $validated['room_slug'])->firstOrFail();
        $durationValue = $validated['duration_value'] ?? null;
        $durationUnit = $validated['duration_unit'] ?? 'months';

        $booking = BookingRequest::create([
            'code' => $this->generateCode(),
            'room_id' => $room->id,
            'user_id' => $user?->id,
            'guest_name' => $validated['guest_name'],
            'guest_email' => $validated['guest_email'],
            'guest_phone' => $validated['guest_phone'] ?? null,
            'move_in_date' => $validated['move_in_date'] ?? null,
            'duration_value' => $durationValue,
            'duration_unit' => $durationUnit,
            'status' => 'pending',
            'source' => 'website',
            'notes' => $validated['notes'] ?? null,
            'total_amount' => $this->calculateAmount($room, $durationValue, $durationUnit),
        ]);

        if ($user) {
            CustomerProfile::query()->firstOrCreate(
                ['user_id' => $user->id],
                ['status' => 'active']
            )->update([
                'phone' => $validated['guest_phone'] ?? $user->customerProfile?->phone,
            ]);
        }

        return redirect()
            ->route('rooms.show', $room->slug)
            ->with('status', 'Booking request ' . $booking->code . ' has been submitted.');
    }

    protected function generateCode(): string
    {
        do {
            $code = 'BK-' . now()->format('ymd') . '-' . Str::upper(Str::random(4));
        } while (BookingRequest::query()->where('code', $code)->exists());

        return $code;
    }

    protected function calculateAmount(Room $room, ?int $durationValue, string $durationUnit): ?float
    {
        if (! $durationValue) {
            return null;
        }

        $dailyRate = $room->daily_rate;

        return match ($durationUnit) {
            'weeks' => round($dailyRate * 7 * $durationValue * 0.9, 2),
            'months' => round((float) $room->price * $durationValue * 0.8, 2),
            default => round($dailyRate * $durationValue, 2),
        };
    }
}
