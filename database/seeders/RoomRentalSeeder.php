<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomRentalSeeder extends Seeder
{
    public function run(): void
    {
        foreach (config('rooms', []) as $room) {
            $record = Room::query()->updateOrCreate(
                ['slug' => $room['slug']],
                [
                    'name' => $room['name'],
                    'location' => $room['location'],
                    'room_type' => $room['capacity'],
                    'price' => (float) str_replace(['$', ','], '', $room['price']),
                    'price_period' => ltrim($room['period'], '/'),
                    'availability_label' => $room['availability'],
                    'capacity_label' => $room['capacity'],
                    'size_label' => $room['size'],
                    'theme' => $room['theme'],
                    'description' => $room['description'],
                    'deposit' => (float) str_replace(['$', ','], '', $room['deposit']),
                    'bathroom' => $room['bathroom'],
                    'furnishing' => $room['furnishing'],
                    'available_from_label' => $room['available_from'],
                    'utilities_label' => $room['utilities'],
                    'visit_label' => $room['visit'],
                    'contract_label' => $room['contract'],
                    'status' => str_contains(strtolower($room['availability']), 'available') || str_contains(strtolower($room['availability']), 'move')
                        ? 'available'
                        : 'occupied',
                    'is_featured' => true,
                ]
            );

            $record->amenities()->delete();
            $record->policies()->delete();

            foreach ($room['amenities'] as $index => $name) {
                $record->amenities()->create([
                    'name' => $name,
                    'sort_order' => $index,
                ]);
            }

            foreach ($room['policies'] as $index => $name) {
                $record->policies()->create([
                    'name' => $name,
                    'sort_order' => $index,
                ]);
            }
        }
    }
}
