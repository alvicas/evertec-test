<?php

namespace App\Http\Controllers\Web\Order;

use App\Models\Order;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class OrderIndexController extends Controller
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
     * index function
     *
     * @return void
     */
    public function index()
    {
        try {
            return  $this->successResponse($this->order->getOrdersPaginated());
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
