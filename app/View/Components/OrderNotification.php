<?php

namespace App\View\Components;

use App\Models\Order;
use App\Constant\ServiceStatus;
use Illuminate\Support\Carbon;
use Illuminate\View\Component;

class OrderNotification extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {


    }
    public function render()
    {
        $orders = Order::with('services')
        ->whereHas('services', function ($query){
            $query->where('status','!=', ServiceStatus::READY);
        })
        ->whereDate('delivery_date', '<=', Carbon::today()->addDays(5)->toDateString())
        ->whereNull('delivered_at')
        ->get();
        return view('components.order-notification')->with('notifications', $orders);
    }
}
