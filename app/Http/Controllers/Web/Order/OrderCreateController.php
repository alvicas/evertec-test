<?php

namespace App\Http\Controllers\Web\Order;

use DateTime;
use App\Models\Order;
use Illuminate\Http\Response;
use App\Services\OrderService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderCreateRequest;

class OrderCreateController extends Controller
{
    /**
     * product
     *
     * @param Order $order
     */
    protected $order;
    
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
     * index function
     *
     * @return void
     */
    public function Create(OrderCreateRequest $orderCreateRequest)
    {
        DB::beginTransaction();
        try {
            $attributes = $orderCreateRequest->all();
            $createData = $this->order->createData($attributes);
            $this->order = $this->order->create($createData);
            $this->orderService->createSessions($this->order);
           
            DB::commit();
            return $this->successResponse($this->order, 201);
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->errorResponse($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
