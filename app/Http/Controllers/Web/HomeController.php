<?php

namespace App\Http\Controllers\Web;

use App\Models\Product;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class HomeController extends Controller
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
     * @return void
     */
    public function home()
    {
        try {
            $products = $this->product->all();
            return view('home', compact('products'));
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}