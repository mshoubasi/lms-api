<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CouponRequest;
use App\Http\Resources\CouponResource;
use App\Models\Coupon;

class CouponController extends Controller
{
    public function index()
    {
        return CouponResource::collection(Coupon::latest()->get());
    }

    public function store(CouponRequest $request)
    {
        $coupon = Coupon::create($request->validated());

        return $this->respondWithSucsses(new CouponResource($coupon));
    }
}
