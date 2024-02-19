<?php

namespace App\Http\Controllers\User;

use Exception;
use App\Models\Order;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;

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

            return $this->respondWithSucsses(new OrderResource($order));
        } catch (Exception $e) {
            return $orderService->handleException($e);
        }
    }

    public function show(Order $order)
    {
        return new OrderResource($order);
    }
}
