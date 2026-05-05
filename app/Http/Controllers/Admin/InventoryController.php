<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

    public function create()
    {
        return view('admin.rooms.create');
    }

    public function edit(Room $room)
    {
        return view('admin.rooms.edit', [
            'room' => $room,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->roomRules());

        $imagePath = $request->file('image')?->store('rooms', 'public');

        Room::create([
            ...$validated,
            'slug' => $this->generateUniqueSlug($validated['name']),
            'image_path' => $imagePath,
            'deposit' => $validated['deposit'] ?? 0,
            'is_featured' => $request->boolean('is_featured'),
        ]);

        return redirect()
            ->route('admin.inventory')
            ->with('status', 'Room added successfully.');
    }

    public function update(Request $request, Room $room): RedirectResponse
    {
        $validated = $request->validate($this->roomRules());

        $imagePath = $room->image_path;

        if ($request->hasFile('image')) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }

            $imagePath = $request->file('image')->store('rooms', 'public');
        }

        $room->update([
            ...$validated,
            'image_path' => $imagePath,
            'deposit' => $validated['deposit'] ?? 0,
            'is_featured' => $request->boolean('is_featured'),
        ]);

        return redirect()
            ->route('admin.inventory')
            ->with('status', 'Room updated successfully.');
    }

    public function destroy(Room $room): RedirectResponse
    {
        if ($room->image_path) {
            Storage::disk('public')->delete($room->image_path);
        }

        $room->delete();

        return redirect()
            ->route('admin.inventory')
            ->with('status', 'Room deleted successfully.');
    }

    protected function roomRules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:255'],
            'room_type' => ['nullable', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'price_period' => ['required', 'integer', 'min:1'],
            'availability_label' => ['nullable', 'string', 'max:255'],
            'capacity_label' => ['nullable', 'string', 'max:255'],
            'size_label' => ['nullable', 'string', 'max:255'],
            'theme' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:5120'],
            'description' => ['nullable', 'string', 'max:2000'],
            'deposit' => ['nullable', 'numeric', 'min:0'],
            'bathroom' => ['nullable', 'string', 'max:255'],
            'furnishing' => ['nullable', 'string', 'max:255'],
            'available_from_label' => ['nullable', 'string', 'max:255'],
            'utilities_label' => ['nullable', 'string', 'max:255'],
            'visit_label' => ['nullable', 'string', 'max:255'],
            'contract_label' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:available,occupied,maintenance'],
            'is_featured' => ['nullable', 'boolean'],
        ];
    }

    protected function generateUniqueSlug(string $name): string
    {
        $baseSlug = Str::slug($name);
        $slug = $baseSlug;
        $counter = 2;

        while (Room::query()->where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
