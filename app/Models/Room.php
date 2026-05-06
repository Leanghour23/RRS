<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
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
        'image_path',
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
        $value = $this->price_period_value;

        if ($value !== null) {
            return '/' . $value . ' month';
        }

        return '/' . $this->price_period;
    }

    public function getPricePeriodValueAttribute(): ?int
    {
        if ($this->price_period === null) {
            return null;
        }

        if (is_numeric($this->price_period)) {
            return (int) $this->price_period;
        }

        if (preg_match('/\d+/', (string) $this->price_period, $matches)) {
            return (int) $matches[0];
        }

        return null;
    }

    public function getDailyRateAttribute(): float
    {
        return round((float) $this->price / 30, 2);
    }

    public function getDailyPriceDisplayAttribute(): string
    {
        return '$' . number_format($this->daily_rate, 2);
    }

    public function getAmenitiesListAttribute(): Collection
    {
        return $this->amenities->pluck('name');
    }

    public function getPoliciesListAttribute(): Collection
    {
        return $this->policies->pluck('name');
    }

    public function getImageUrlAttribute(): ?string
    {
        if (! $this->image_path) {
            return null;
        }

        return Storage::url($this->image_path);
    }
}
