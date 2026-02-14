<?php

namespace App\Http\Controllers\Api\Website;

use App\Http\Controllers\Controller;
use App\Http\Resources\Website\ProductResource;
use App\Http\Resources\Website\ServiceResource;
use App\Http\Resources\Website\SliderResource;
use App\Models\Product;
use App\Models\Service;
use App\Models\Slider;
use App\Support\Enums\Main\StatusEnum;
use App\Support\Traits\Api\ApiResponseTrait;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    use ApiResponseTrait;

    /**
     * Get all home page data including sliders, products, and services.
     */
    public function index(Request $request)
    {
        // Get limit from request or use defaults
        $sliderLimit = $request->get('slider_limit', 5);
        $productLimit = $request->get('product_limit', 6);
        $serviceLimit = $request->get('service_limit', 6);

        // Get active sliders (boolean status)
        $sliders = Slider::where('status', true)
            ->orderBy('created_at', 'desc')
            ->limit($sliderLimit)
            ->get();

        // Get active products (enum status)
        $products = Product::where('status', StatusEnum::ACTIVE)
            ->orderBy('created_at', 'desc')
            ->limit($productLimit)
            ->get();

        // Get active services (boolean status)
        $services = Service::where('status', true)
            ->orderBy('created_at', 'desc')
            ->limit($serviceLimit)
            ->get();

        // Return aggregated data
        return $this->responseData([
            'sliders' => SliderResource::collection($sliders),
            'products' => ProductResource::collection($products),
            'services' => ServiceResource::collection($services),
        ]);
    }
}

