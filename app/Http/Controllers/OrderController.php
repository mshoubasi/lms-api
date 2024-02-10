<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Course;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Notifications\OrderNotification;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders;

        return OrderResource::collection($orders);
    }

    public function store(Request $request, Course $course)
    {
        try {
            $request->validate([
                'code' => 'nullable|string|exists:coupons,code'
            ]);

            // Check if user already owns the course (optimized):
            if (Order::where('user_id', auth()->user()->id)->where('course_id', $course->id)->exists()) {
                throw new Exception('You already own this course.');
            }

            $final_price = $course->selling_price;

            // Apply discount if valid coupon provided:
            if ($request->has('code')) {
                $today = Carbon::today();
                $discount = Coupon::where('code', '=', $request->code)->first();

                if ($discount) {
                    if ($discount->expires_at < $today) {
                        throw new Exception('Coupon has expired.');
                    }

                    $final_price = max($course->selling_price - $discount->amount, 0); // Ensure non-negative price
                } else {
                    throw new Exception('Invalid coupon code.');
                }
            }

            // Securely generate unique order code:
            $orderCode = Str::uuid();

            // Create order:
            $order = Order::create([
                'user_id' => auth()->user()->id,
                'course_id' => $course->id,
                'order_code' => $orderCode,
                'date' => Carbon::now(),
                'final_price' => $final_price,
            ]);

            $data = [
                'message' => 'Your order has been confirmed!',
                'order' => $order,
            ];

            auth()->user()->notify(new OrderNotification($data));

            return new OrderResource($order);
        } catch (Exception $e) {
            // Handle exceptions gracefully with informative error messages:
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }


    public function show(Order $order)
    {
        return new OrderResource($order);
    }
}
