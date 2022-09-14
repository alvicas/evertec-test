<?php

namespace App\Http\Controllers\Web;

use App\Models\Product;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class ProductIndexController extends Controller
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
     * index function
     *
     * @return void
     */
    public function index()
    {
        try {
            return  $this->successResponse($this->product->getProductsPaginated());
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        
    }

}
