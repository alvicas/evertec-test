<?php

namespace App\Http\Controllers\Web\Order;

use App\Models\Order;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;

class OrderShowController extends Controller
{

    /**
     * show
     *
     * @param int $orderId
     * @return void
     */
    public function show(Order $order)
    {
        try {

            $order->status = $order->getStatus();
            $order->payment_status = $order->getPaymentStatus();
            $order->productName = $order->product->name;

            return view('order/orderDetail', compact('order'));
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
