<?php

namespace App\Http\Controllers\Web\Order;

use App\Models\Order;
use Illuminate\Http\Response;
use App\Services\OrderService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PayOrderController extends Controller
{

    /**
     * orderService
     *
     * @param OrderService $orderService
     */
    protected $orderService;

    /**
     * OrderIndexController constructor
     *
     * @param Order $order
     */
    public function __construct(Order $order, OrderService $orderService)
    {
        $this->order = $order;
        $this->orderService = $orderService;
    }

    /**
     * payOrder
     *
     * @param int $orderId
     * @return void
     */
    public function paymentAttemp(Order $order)
    {
        DB::beginTransaction();
        try {
            $sessionPaymentRequest = $this->orderService->createSessions($order);
            $this->orderService->updateOrderByPaymentRequest($order, $sessionPaymentRequest);
            
            DB::commit();
            return $this->successResponse($order, 201);
        } catch (\Exception $exception) {

            DB::rollBack();
            return $this->errorResponse($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
