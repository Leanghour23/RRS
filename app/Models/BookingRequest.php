<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'room_id',
        'user_id',
        'guest_name',
        'guest_email',
        'guest_phone',
        'move_in_date',
        'duration_value',
        'duration_unit',
        'status',
        'source',
        'notes',
        'total_amount',
    ];

    protected $casts = [
        'move_in_date' => 'date',
        'total_amount' => 'decimal:2',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getDurationDisplayAttribute(): string
    {
        if (! $this->duration_value) {
            return 'Flexible';
        }

        return $this->duration_value . ' ' . $this->duration_unit;
    }
}
