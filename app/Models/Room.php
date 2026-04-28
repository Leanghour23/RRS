<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'location',
        'room_type',
        'price',
        'price_period',
        'availability_label',
        'capacity_label',
        'size_label',
        'theme',
        'description',
        'deposit',
        'bathroom',
        'furnishing',
        'available_from_label',
        'utilities_label',
        'visit_label',
        'contract_label',
        'status',
        'is_featured',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'deposit' => 'decimal:2',
        'is_featured' => 'boolean',
    ];

    public function amenities(): HasMany
    {
        return $this->hasMany(RoomAmenity::class)->orderBy('sort_order');
    }

    public function policies(): HasMany
    {
        return $this->hasMany(RoomPolicy::class)->orderBy('sort_order');
    }

    public function bookingRequests(): HasMany
    {
        return $this->hasMany(BookingRequest::class);
    }

    public function getPriceDisplayAttribute(): string
    {
        return '$' . number_format((float) $this->price, 0);
    }

    public function getDepositDisplayAttribute(): string
    {
        return '$' . number_format((float) $this->deposit, 0);
    }

    public function getPeriodDisplayAttribute(): string
    {
        return '/' . $this->price_period;
    }

    public function getAmenitiesListAttribute(): Collection
    {
        return $this->amenities->pluck('name');
    }

    public function getPoliciesListAttribute(): Collection
    {
        return $this->policies->pluck('name');
    }
}
