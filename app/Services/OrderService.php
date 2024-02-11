<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\Course;
use App\Models\Order;
use App\Notifications\OrderNotification;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class OrderService
{
    public function validateCoupon(Request $request, Course $course)
    {
        $request->validate([
            'code' => 'nullable|string|exists:coupons,code',
        ]);

        if (Order::where('user_id', auth()->id())->where('course_id', $course->id)->exists()) {
            throw new Exception('You already own this course.');
        }
    }

    public function applyDiscount(Request $request): Coupon
    {
        $today = Carbon::today();
        $discount = Coupon::where('code', $request->code)->firstOrFail();

        if ($discount->expires_at < $today) {
            throw new Exception('Coupon has expired.');
        }

        return $discount;
    }

    public function createOrder(Course $course, float $finalPrice): Order
    {
        return Order::create([
            'user_id' => auth()->id(),
            'course_id' => $course->id,
            'order_code' => Str::uuid(),
            'date' => Carbon::now(),
            'final_price' => $finalPrice,
        ]);
    }

    public function notifyUser(Order $order)
    {
        auth()->user()->notify(new OrderNotification([
            'message' => 'Your order has been confirmed!',
            'order' => $order,
        ]));
    }

    public function handleException(Exception $e): JsonResponse
    {
        return response()->json(['error' => $e->getMessage()], 400);
    }
}
