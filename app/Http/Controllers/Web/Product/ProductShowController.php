<?php

namespace App\Http\Controllers\Web\Product;

use App\Models\Product;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class ProductShowController extends Controller
{
    /**
     * product
     *
     * @param Product $product
     */
    protected $product;

    /**
     * ProductIndexController constructor
     *
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * show
     *
     * @param int $productId
     * @return void
     */
    public function show(int $productId)
    {
        try {
            $this->product = $this->product->get($productId);
            return $this->successResponse($this->product);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
