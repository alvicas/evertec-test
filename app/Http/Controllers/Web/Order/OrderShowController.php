<?php

namespace App\Http\Controllers\Web\Product;

use App\Models\Order;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class OrderShowController extends Controller
{
    /**
     * product
     *
     * @param Order $order
     */
    protected $order;

    /**
     * OrderIndexController constructor
     *
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * show
     *
     * @param int $orderId
     * @return void
     */
    public function show(int $orderId)
    {
        try {
            $this->order = $this->order->get($orderId);
            return $this->successResponse($this->order);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
