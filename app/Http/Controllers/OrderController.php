<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Notifications\OrderNotification;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders;

        return OrderResource::collection($orders);
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => ['required', 'exists:courses,id']
        ]);

        if (auth()->user()->orders()->where('course_id', $request->course_id)->exists()) {
            throw new Exception('You already own this course.');
        }

        $order = Order::create([
            'user_id' => auth()->user()->id,
            'course_id' => $request->course_id,
            'order_code' => rand(1000, 9999),
            'date' => Carbon::now(),
        ]);

        $data = [
            'message' => 'you order has been confirmed',
            'order' => $order,
        ];

        auth()->user()->notify(new OrderNotification($data));

        return new OrderResource($order);
    }

    public function show(Order $order)
    {
        return new OrderResource($order);
    }

}
