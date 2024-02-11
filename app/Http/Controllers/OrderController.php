<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Course;
use App\Models\Order;
use App\Services\OrderService;
use Exception;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders;

        return OrderResource::collection($orders);
    }

    public function store(Request $request, Course $course, OrderService $orderService)
    {
        try {
            $orderService->validateCoupon($request, $course); // Separate validation logic

            $finalPrice = $course->selling_price;

            if ($request->has('code')) {
                $discount = $orderService->applyDiscount($request);
                $finalPrice = max($finalPrice - $discount->amount, 0); // Ensure non-negative price
            }

            $order = $orderService->createOrder($course, $finalPrice);
            $orderService->notifyUser($order);

            return new OrderResource($order);
        } catch (Exception $e) {
            return $orderService->handleException($e);
        }
    }

    public function show(Order $order)
    {
        return new OrderResource($order);
    }
}
