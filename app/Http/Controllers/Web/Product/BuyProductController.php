<?php

namespace App\Http\Controllers\Web\Product;

use App\Models\Product;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class BuyProductController extends Controller
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
     * Undocumented function
     *
     * @param Product $product
     * @return void
     */
    public function buyProduct(Product $product)
    {
        try {
            return view('User/userPersonalInformation', compact('product'));
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
