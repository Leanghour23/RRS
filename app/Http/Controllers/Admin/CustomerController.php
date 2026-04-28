<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerProfile;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = CustomerProfile::query()->with('user')->latest()->get();

        return view('admin.customers', [
            'customerStats' => [
                ['value' => $customers->where('status', 'active')->count(), 'label' => 'Active Customers'],
                ['value' => $customers->where('created_at', '>=', now()->startOfMonth())->count(), 'label' => 'New This Month'],
                ['value' => $customers->where('is_vip', true)->count(), 'label' => 'VIP Renters'],
                ['value' => $customers->count(), 'label' => 'Total Profiles'],
            ],
            'customers' => $customers,
        ]);
    }
}
